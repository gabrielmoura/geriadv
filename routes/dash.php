<?php

use App\Http\Controllers\Adm\UsersController;
use App\Http\Controllers\Auth\DashController;
use App\Http\Controllers\Adm\ClientController;
use App\Http\Controllers\Adm\AnalyticsController;
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

Route::group(['prefix' => 'admin','middleware'=>'auth:web'], function () {
    /*
    |------------------------------------------------------------------------------------
    | Admin
    |------------------------------------------------------------------------------------
    */
    Route::get('/', [UsersController::class, 'index'])->name('admin.index');

    Route::resource('/usuario', UsersController::class)
        ->names('admin.users');
    Route::resource('/client', ClientController::class)
        ->names('admin.clients');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('admin.analytic.index');
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
