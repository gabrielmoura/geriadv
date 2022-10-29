<?php

use App\Http\Controllers\Adm\{AppointmentsController,
    AnalyticsController,
    BenefitsController,
    ClientController,
    CompanyController,
    EmployeeController,
    HomeAdmController,
    LawyerController,
    LogActivityController,
    PendencyController,
    UsersController,
    BilletsController,
    PaymentController
};
use \App\Http\Controllers\CompanyConfigController;
use App\Http\Controllers\Adm\UploadController;
use App\Http\Controllers\Auth\{ActivityControlController, DashController, LogoutOtherBrowserSessionsController};
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| DashBoard Routes
|--------------------------------------------------------------------------
|
*/


Route::group(['prefix' => 'admin', 'middleware' => ['auth:web', 'verifyBanned'], 'as' => 'admin.'], function () {
    /*
    |------------------------------------------------------------------------------------
    | Admin
    |------------------------------------------------------------------------------------
    */
    Route::get('/', [HomeAdmController::class, 'index'])->name('index')->middleware('cache.headers:private;');

    Route::resource('/usuario', UsersController::class)->names('users');
    Route::resource('/company', CompanyController::class)->names('company');
    Route::get('/company/iframe/{id}', [CompanyController::class, 'showIframe'])->name('company.iframe');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytic.index');
    Route::get('/logActivity', [LogActivityController::class, 'index'])->name('log.activity');
    Route::get('/ActivityControl', [ActivityControlController::class, 'index'])->name('ActivityControl');
    Route::post('/ActivityControl', [ActivityControlController::class, 'store'])->name('ActivityControl.store');

    Route::group(['middleware' => ['restrictedToDayLight']], function () {
        Route::resource('/employee', EmployeeController::class)->names('employee')->middleware('role:manager');
        Route::resource('/benefit', BenefitsController::class)->names('benefit');
        Route::resource('/lawyer', LawyerController::class)->names('lawyer');
        Route::post('/client/pendency', [PendencyController::class, 'store'])->name('clients.pendency');
        Route::get('/client/pendency', [PendencyController::class, 'download'])->name('clients.pendency.download');
        Route::delete('/client/pendency', [PendencyController::class, 'delete'])->name('clients.pendency.delete');
        Route::get('/client/payments', [ClientController::class, 'payments'])->name('clients.payments');
        Route::get('/client/{slug}/payments/', [ClientController::class, 'payments'])->middleware(['can:edit_payment'])->name('clients.payments.show');
        Route::resource('/client', ClientController::class)->names('clients');

        //  Pagamentos
        Route::group(['prefix' => '/payment', 'as' => 'payment.'], function () {
            Route::get('/', [PaymentController::class, 'index'])->middleware(['can:edit_payment'])->name('index');
            Route::resource('/billet', BilletsController::class)->middleware(['can:edit_payment'])->names('billets');
        });

        // Calendário
        Route::resource('schedules', AppointmentsController::class)->names('calendar');
        Route::group(['as' => 'calendar.'], function () {
            Route::delete('schedules/destroy', [AppointmentsController::class, 'massDestroy'])->name('massDestroy');
            Route::get('schedule/calendar', [AppointmentsController::class, 'indexShow'])->name('systemCalendar');
        });

        // Notifications
        Route::group(['prefix' => 'notifications', 'as' => 'notifications.'], function () {
            Route::get('Unread', [NotificationController::class, 'index'])->name('index');
            Route::get('All', [NotificationController::class, 'all'])->name('all');

            Route::post('notifications', [NotificationController::class, 'store'])->name('store');
            Route::get('/', [NotificationController::class, 'getNotifications'])->name('getNotifications');
            Route::get('/create', [NotificationController::class, 'create'])->name('create');
            Route::post('/sent', [NotificationController::class, 'sent'])->name('sent');
            Route::post('/read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
            Route::post('/mark-all-read', [NotificationController::class, 'markAllRead'])->name('markAllRead');
            Route::post('/{id}/dismiss', [NotificationController::class, 'dismiss'])->name('dismiss');
        });
    });
    Route::get('test', function () {
        return \App\Models\ClientView::all();
    });
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/redirAuth/{user}', function ($user) {
            \Illuminate\Support\Facades\Auth::loginUsingId($user);
            \Illuminate\Support\Facades\Log::info('authenticated to another user using special permissions levels.', [
                'by' => \Illuminate\Support\Facades\Auth::user(),
                'user' => $user
            ]);
            return redirect()->route('home');
        })->name('auth.redir');
        Route::resource('/role', \App\Http\Controllers\Auth\PermissionController::class);
    });
});


Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/redirDASH', [DashController::class, '__invoke'])->name('redirDASH');


    Route::get('/me/setting', function () {
        return view('auth.profile.profile');
    })->name('user.setting');
    Route::get('/me/company', [CompanyConfigController::class, 'index'])->name('company.setting')->middleware('role:manager');
    Route::post('/me/company', [CompanyConfigController::class, 'update'])->name('company.setting.update')->middleware('role:manager');

    Route::post('/me/browser', [LogoutOtherBrowserSessionsController::class, 'logoutOtherBrowserSessions'])
        ->name('user.setting.logoutBrowser');

    Route::group(['prefix' => 'upload'], function () {
        Route::post('dropzone', [UploadController::class, 'storeMedia'])
            ->name('upload.dropzone');
    });

});
