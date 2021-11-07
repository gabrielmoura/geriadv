<?php

use App\Events\TestEvent;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PushController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Adm\AgendamentoController;
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
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'auth', 'as' => 'socialite.'], function () {
    Route::get('/{slug}/callback', [SocialiteController::class, 'callback'])->name('callback');
    Route::get('/{slug}/redirect', [SocialiteController::class, 'redirect'])->name('redirect');
});



Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return redirect()->route('redirDASH');
    })->name('home');

    Route::get('/user/profile', function () {
        return view('profile');
    })->name('profile');
});


//make a push notification.
Route::get('/push', [PushController::class, 'push'])->name('push');

//store a push subscriber.
Route::post('/push', [PushController::class, 'store']);

Route::get('/notificate', function () {
    return event(new TestEvent('Teste Pusher em fucionamento'));
});
// Push Subscriptions

Route::group(['prefix' => 'subscriptions'], function () {
    Route::post('/', [PushController::class, 'update']);
    Route::post('/delete', [PushController::class, 'destroy']);
});

// Notifications
Route::group(['prefix' => 'notifications', 'as' => 'notifications.'], function () {
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
