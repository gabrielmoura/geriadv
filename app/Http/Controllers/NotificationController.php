<?php

namespace App\Http\Controllers;

use App\Events\NotificationRead;
use App\Events\NotificationReadAll;
use App\Notifications\PushDemo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NotificationChannels\WebPush\PushSubscription;

/**
 * Controlar Notificações
 * Class NotificationController
 * @package App\Http\Controllers
 */
class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('last', 'dismiss');
    }

    public function index()
    {
        $notifications = Auth::user()->unreadNotifications()->get();
        return view('profile.notification', compact('notifications'));
    }

    public function all()
    {
        $notifications = Auth::user()->notifications()->get();
        return view('profile.notification', compact('notifications'));
    }


    /**
     * @param Request $request
     * @return array|\never
     */
    public function getNotifications(Request $request)
    {
        if ($request->ajax()) {
            $user = $request->user();

            // Limit the number of returned notifications, or return all
            $query = $user->unreadNotifications();
            $limit = (int)$request->input('limit', 0);
            if ($limit) {
                $query = $query->limit($limit);
            }

            $notifications = $query->get()->each(function ($n) {
                $n->created = $n->created_at->toIso8601String();
            });

            $total = $user->unreadNotifications->count();

            return compact('notifications', 'total');
        }
        return abort(405, "Não Permitido");
    }


    /**
     * Create a new notification.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Send notification to other user
        // $to= User::where("id",2)->first();
        // $to->notify(new HelloNotification("Hei, its work"));

        //Send notification to yourself
        $request->user()->notify(new PushDemo("Hei, its work"));

        return response()->json('Notification sent.', 201);
    }

    /**
     * Mark user's notification as read.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request)
    {
        $notification = $request->user()
            ->unreadNotifications()
            ->where('id', $request->id)
            ->first();

        if (is_null($notification)) {
            return response()->json('Notification not found.', 404);
        }

        $notification->markAsRead();

        event(new NotificationRead($request->user()->id, $request->id));
    }

    /**
     * Mark all user's notifications as read.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function markAllRead(Request $request)
    {
        $request->user()
            ->unreadNotifications()
            ->get()->each(function ($n) {
                $n->markAsRead();
            });

        event(new NotificationReadAll($request->user()->id));
    }


    /**
     * Mark the notification as read and dismiss it from other devices.
     *
     * This method will be accessed by the service worker
     * so the user is not authenticated and it requires an endpoint.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function dismiss(Request $request, $id)
    {
        if (empty($request->endpoint)) {
            return response()->json('Endpoint missing.', 403);
        }

        $subscription = PushSubscription::findByEndpoint($request->endpoint);
        if (is_null($subscription)) {
            return response()->json('Subscription not found.', 404);
        }

        $notification = $subscription->user->notifications()->where('id', $id)->first();
        if (is_null($notification)) {
            return response()->json('Notification not found.', 404);
        }

        $notification->markAsRead();

        event(new NotificationRead($subscription->user->id, $id));
    }
}
