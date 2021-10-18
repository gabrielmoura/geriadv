<?php

use App\Http\Controllers\Adm\AgendamentoController;
use App\Http\Controllers\Adm\AnalyticsController;
use App\Http\Controllers\Adm\ClientController;
use App\Http\Controllers\Adm\CompanyController;
use App\Http\Controllers\Adm\EmployeeController;
use App\Http\Controllers\Adm\LogActivityController;
use App\Http\Controllers\Adm\PendencyController;
use App\Http\Controllers\Adm\UsersController;
use App\Http\Controllers\Auth\ActivityControlController;
use App\Http\Controllers\Auth\DashController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| DashBoard Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/kkk', function () {
    echo "Painel Funcioários";
})->name('employee.index');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:web','as'=>'admin.'], function () {
    /*
    |------------------------------------------------------------------------------------
    | Admin
    |------------------------------------------------------------------------------------
    */
    Route::get('/', [UsersController::class, 'index'])->name('index');

    Route::resource('/usuario', UsersController::class)->names('users');
    Route::resource('/company', CompanyController::class)->names('company');
    Route::get('/company/iframe', [CompanyController::class, 'iframe'])->name('company.iframe');
    Route::resource('/employee', EmployeeController::class)->names('employee');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytic.index');
    Route::get('/logActivity', [LogActivityController::class, 'index'])->name('log.activity');
    Route::get('/ActivityControl', [ActivityControlController::class, 'index'])->name('ActivityControl');
    Route::post('/ActivityControl', [ActivityControlController::class, 'store'])->name('ActivityControl.store');

    Route::group(['middleware' => 'restrictedToDayLight'], function () {
        Route::resource('/client', ClientController::class)->names('clients');
        Route::post('/client/pendency', [PendencyController::class, 'store'])->name('clients.pendency');
        Route::delete('/client/pendency', [PendencyController::class, 'delete'])->name('clients.pendency.delee');


        // Calendário
        Route::resource('schedules', AgendamentoController::class)->names('calendar');
        Route::group(['as' => 'calendar.'], function () {
            Route::delete('schedules/destroy', [AgendamentoController::class, 'massDestroy'])->name('massDestroy');
            Route::get('schedule/calendar', [AgendamentoController::class, 'indexShow'])->name('systemCalendar');
        });
    });


});


Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/redirDASH', [DashController::class, '__invoke'])->name('redirDASH');


//Route::get('/dash', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dash');
    Route::get('/me/setting', function () {
        return view('auth.profile.profile');
    })->name('user.setting');

    Route::group(['prefix' => 'dash'], function () {
        //Route::get('/dash', [HomeController::class, 'index'])->name('dash.index');
        //  Route::get('/', [OrderController::class, 'index'])->name('client.index');
    });
});
