<?php

use App\Events\TestEvent;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PushController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/notificate', function () {
    return event(new TestEvent('Teste Pusher em fucionamento'));
});

Route::get('/auth/{slug}/callback', [SocialiteController::class, 'callback']);
Route::get('/auth/{slug}/redirect', [SocialiteController::class, 'redirect']);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/user/profile', function () {
        return view('profile');
    })->name('profile');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/user/profile', function () {
        return view('profile');
    })->name('profile');
});


//make a push notification.
Route::get('/push', [PushController::class, 'push'])->name('push');

//store a push subscriber.
Route::post('/push', [PushController::class, 'store']);

// Push Subscriptions
Route::post('subscriptions', [PushController::class, 'update']);
Route::post('subscriptions/delete', [PushController::class, 'destroy']);


// Notifications
Route::middleware(['auth'])->group(['name'=>'notifications.','prefix'=>'notifications'],fuction(){
    Route::get('All', [NotificationController::class, 'index'])->name('index');

    Route::post('notifications', [NotificationController::class, 'store'])->name('store');
    Route::get('/', [NotificationController::class, 'getNotifications'])->name('getNotifications');
    Route::patch('/{id}/read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllRead'])->name('markAllRead');
    Route::post('/{id}/dismiss', [NotificationController::class, 'dismiss'])->name('dismiss');
});


Route::get('manifest.json', function () {


    $manifest = [
        'name' => config('app.name'),
        'short_name' => config('app.name'),
        'start_url' => '.',
        'display' => 'standalone',
        'background_color' => '#060606',
        'description' => config('app.name'),
        'icons' => [
            [
                'src' => url('images/logo.png'),
                'sizes' => '256x256',
                'type' => 'image/png',
            ],
            [
                'src' => url('images/logo.png'),
                'sizes' => '500x500',
                'type' => 'image/png',
            ],
            [
                'src' => url('images/logo.png'),
                'sizes' => '791x305',
                'type' => 'image/png',
            ],
        ],
    ];
    if (config('webpush.gcm.sender_id')) {
        return array_merge($manifest, ['gcm_sender_id' => config('webpush.gcm.sender_id')],);
    } else {
        return $manifest;
    }

});
