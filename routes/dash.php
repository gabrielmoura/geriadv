<?php

use App\Http\Controllers\Adm\{AgendamentoController,
    AnalyticsController,
    BenefitsController,
    ClientController,
    CompanyController,
    EmployeeController,
    HomeAdmController,
    LawyerController,
    LogActivityController,
    PendencyController,
    UsersController
};
use App\Http\Controllers\Auth\{ActivityControlController, DashController};
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| DashBoard Routes
|--------------------------------------------------------------------------
|
*/


Route::group(['prefix' => 'admin', 'middleware' => 'auth:web', 'as' => 'admin.'], function () {
    /*
    |------------------------------------------------------------------------------------
    | Admin
    |------------------------------------------------------------------------------------
    */
    Route::get('/', [HomeAdmController::class, 'index'])->name('index');

    Route::resource('/usuario', UsersController::class)->names('users');
    Route::resource('/company', CompanyController::class)->names('company');
    Route::get('/company/iframe/{id}', [CompanyController::class, 'showIframe'])->name('company.iframe');
    Route::resource('/employee', EmployeeController::class)->names('employee')->middleware('role:manager');
    Route::resource('/benefit', BenefitsController::class)->names('benefit');
    Route::resource('/lawyer', LawyerController::class)->names('lawyer');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytic.index');
    Route::get('/logActivity', [LogActivityController::class, 'index'])->name('log.activity');
    Route::get('/ActivityControl', [ActivityControlController::class, 'index'])->name('ActivityControl');
    Route::post('/ActivityControl', [ActivityControlController::class, 'store'])->name('ActivityControl.store');

    Route::group(['middleware' => 'restrictedToDayLight'], function () {
        Route::post('/client/pendency', [PendencyController::class, 'store'])->name('clients.pendency');
        Route::delete('/client/pendency', [PendencyController::class, 'delete'])->name('clients.pendency.delete');
        Route::resource('/client', ClientController::class)->names('clients');


        // Calendário
        Route::resource('schedules', AgendamentoController::class)->names('calendar');
        Route::group(['as' => 'calendar.'], function () {
            Route::delete('schedules/destroy', [AgendamentoController::class, 'massDestroy'])->name('massDestroy');
            Route::get('schedule/calendar', [AgendamentoController::class, 'indexShow'])->name('systemCalendar');
        });
    });
    Route::get('test', function () {
        return \App\Models\ClientView::all();
    });

    Route::middleware(['role:admin'])->get('/redirAuth/{user}', function ($user) {
        \Illuminate\Support\Facades\Auth::loginUsingId($user);
        \Illuminate\Support\Facades\Log::info('authenticated to another user using special permissions levels.', [
            'by' => \Illuminate\Support\Facades\Auth::user(),
            'user' => $user
        ]);
        return redirect()->route('home');
    })->name('auth.redir');

});


Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/redirDASH', [DashController::class, '__invoke'])->name('redirDASH');


    Route::get('/me/setting', function () {
        return view('auth.profile.profile');
    })->name('user.setting');


});
