<?php

use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
|
*/

Route::middleware(['auth'])->prefix('ajax')->name('ajax.')->group(function () {
    Route::post('getNote', [AjaxController::class, 'getNote'])->name('getNote');
    Route::post('setNote', [AjaxController::class, 'setNote'])->name('setNote');

    Route::post('getStatus', [AjaxController::class, 'getStatus'])->name('getStatus');
    Route::post('getByStatus', [AjaxController::class, 'getByStatus'])->name('getByStatus');
    Route::post('setStatus', [AjaxController::class, 'setStatus'])->name('setStatus');

    Route::post('getPendency', [AjaxController::class, 'getPendency'])->name('getPendency');
    Route::post('getSheduled', [AjaxController::class, 'getSheduled'])->name('getSheduled');

    Route::post('setBenefit', [AjaxController::class, 'setBenefit'])->name('setBenefit');
    Route::post('setRecommendation', [AjaxController::class, 'setRecommendation'])->name('setRecommendation');

    Route::post('sendMail', [AjaxController::class, 'sendMail'])->name('sendMail');

    /**
     * Busca Funcionários
     */
    Route::post('getEmployees', [AjaxController::class, 'getEmployees'])->name('getEmployees');

    Route::post('getCep', [AjaxController::class, 'getCep'])->name('getCep');

    //  Busca informações do calendário
    Route::get('getCalendar', [AjaxController::class, 'getCalendar'])->name('getCalendar');

});
