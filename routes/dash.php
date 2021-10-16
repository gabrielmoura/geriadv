<?php

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

Route::group(['prefix' => 'admin', 'middleware' => 'auth:web'], function () {
    /*
    |------------------------------------------------------------------------------------
    | Admin
    |------------------------------------------------------------------------------------
    */
    Route::get('/', [UsersController::class, 'index'])->name('admin.index');

    Route::resource('/usuario', UsersController::class)->names('admin.users');
    Route::resource('/company', CompanyController::class)->names('admin.company');
    Route::get('/company/iframe', [CompanyController::class, 'iframe'])->name('admin.company.iframe');
    Route::resource('/employee', EmployeeController::class)->names('admin.employee');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('admin.analytic.index');
    Route::get('/logActivity', [LogActivityController::class, 'index'])->name('admin.log.activity');
    Route::get('/ActivityControl', [ActivityControlController::class, 'index'])->name('admin.ActivityControl');
    Route::post('/ActivityControl', [ActivityControlController::class, 'store'])->name('admin.ActivityControl.store');

    Route::group(['middleware' => 'restrictedToDayLight'], function () {
        Route::resource('/client', ClientController::class)->names('admin.clients');
        Route::post('/client/pendency', [PendencyController::class, 'store'])->name('admin.clients.pendency');
        Route::delete('/client/pendency', [PendencyController::class, 'delete'])->name('admin.clients.pendency.delee');
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
