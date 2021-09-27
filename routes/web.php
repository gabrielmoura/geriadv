<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Pusher\Pusher;

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
use App\Events\TestEvent;
Route::get('/notificate', function () {
    return event(new TestEvent('Monique é gostosa'));
});

//Route::get('/auth/{slug}/callback', [SocialiteController::class, 'callback']);
//Route::get('/auth/{slug}/redirect', [SocialiteController::class, 'redirect']);

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
use Maatwebsite\Excel\Facades\Excel;
use App\Actions\Excel\Import\ImportContratosAssinadosExcel as Import;

Route::get('/exxx',function(){
    //$file=storage_path('app/contratos_assinados.xlsx');
    ini_set('memory_limit', '-1');

    Excel::import(new Import(),storage_path('app/contratos_assinados.csv'));
});

