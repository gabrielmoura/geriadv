<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;

class LogoutOtherBrowserSessionsController extends Controller
{
    public function logoutOtherBrowserSessions(StatefulGuard $guard)
    {
        //$this->resetErrorBag();

        if (!Hash::check(request('password'), Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);
        }

        $guard->logoutOtherDevices(request('password'));

        $this->deleteOtherSessionRecords();
        toastr()->success('Deslogado com sucesso.');
        return redirect()->route('user.setting');

        //$this->confirmingLogout = false;

        //$this->emit('loggedOut');
    }


    /**
     * Delete the other browser session records from storage.
     *
     * @return void
     */
    protected function deleteOtherSessionRecords()
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where('id', '!=', request()->session()->getId())
            ->delete();
        activity()
            ->inLog('sessions')
            ->causedBy(Auth::user()->getAuthIdentifier())
            ->withProperties([
                'session_id' => request()->session()->getId(),
                'user_id' => Auth::id()
            ])
            ->log(__('global.browser.deleted'));
    }

    /**
     * Get the current sessions.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSessionsProperty()
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                ->where('user_id', Auth::user()->getAuthIdentifier())
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) {
            return (object)[
                'agent' => $this->createAgent($session),
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param mixed $session
     * @return \Jenssegers\Agent\Agent
     */
    protected function createAgent($session)
    {
        //dd((new Agent)->isMobile());
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('auth.logout-other-session');
    }
}
