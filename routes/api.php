<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{ClientApiController, UserApiController, CompanyApiController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', function () {
    return request()->all();
});

Route::post('/auth', function (Request $request) {
    $auth = auth();
    if ($auth->attempt($request->only('email', 'password'))) {
        if (!$auth->user()->hasPermissionTo('use_api')) return response(null, 401);
        $token = $auth->user()->createToken($request->token_name);
        return ['token' => $token->plainTextToken];
    }
    return response(null, 401);
}
);


Route::middleware('auth:sanctum')->group(function () {
    //  Retorna todos os dados do usuário atual
    Route::get('/me', function (Request $request) {
        return $request->user();
    });
    //  Revoga token em uso
    Route::post('/auth/revoke', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
    });
    //  Revoga todos os tokens
    Route::post('/auth/warning', function (Request $request) {
        $request->user()->tokens()->delete();
    });

    Route::get('/clients', [ClientApiController::class, 'index']);
    Route::get('/client/{id}', [ClientApiController::class, 'show']);

    Route::get('/users', [UserApiController::class, 'index']);
    Route::get('/user/{id}', [UserApiController::class, 'show']);

    Route::get('/companies', [CompanyApiController::class, 'index']);
    Route::get('/company/{id}', [CompanyApiController::class, 'show']);
});
