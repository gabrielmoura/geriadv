<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    ClientApiController,
    UserApiController,
    CompanyApiController,
    LawyerApiController,
    EmployerApiController,
    AnalyticsApiController
};
use Spatie\Permission\Models\Permission;

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
    try {
        $auth = auth();
        if ($auth->attempt($request->only('email', 'password'))) {
            if (!$auth->user()->hasPermissionTo('use_api')) return response(null, 401);
            $request->validate(['ability'=>'min:3','token_name'=>'required']);
            $token = $auth->user()->createToken($request->token_name, explode(',', $request->ability) ?? ['not']);
            return ['token' => $token->plainTextToken];
        }
    }catch (Exception $e){
        return response()->json(['error'=>$e->getMessage()],$e->getCode());
    }
});


Route::middleware('auth:sanctum')->group(function () {
    //  Autoriza usuário[email,id] a solicitar token
    Route::middleware(['ability:admin'])->post('permissionTo', function (Request $request) {
        try {
            $permission = Permission::where('name', 'use_api')->get();
            $user = User::where('id', $request->user_id)
                ->orWhere('email', $request->email)
                ->first();
            return $user->syncPermissions($permission);
        }catch (Exception $e){
            return response()->json(['error'=>$e->getMessage()],$e->getCode());
        }
    });

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

    Route::middleware(['ability:clients'])->group(function () {
        Route::get('/clients', [ClientApiController::class, 'index']);
        Route::get('/client/{id}', [ClientApiController::class, 'show']);
    });

    Route::middleware(['ability:users'])->group(function () {
        Route::get('/users', [UserApiController::class, 'index']);
        Route::get('/user/{id}', [UserApiController::class, 'show']);
    });

    Route::middleware(['ability:users,lawyer'])->group(function () {
        Route::get('/lawyers', [LawyerApiController::class, 'index']);
        Route::get('/lawyer/{id}', [LawyerApiController::class, 'show']);
    });

    Route::middleware(['ability:users,employer'])->group(function () {
        Route::get('/employers', [EmployerApiController::class, 'index']);
        Route::get('/employer/{id}', [EmployerApiController::class, 'show']);
    });

    Route::middleware(['ability:companies'])->group(function () {
        Route::get('/companies', [CompanyApiController::class, 'index']);
        Route::get('/company/{id}', [CompanyApiController::class, 'show']);

    });

    Route::middleware(['ability:analytics'])->group(function () {
        Route::get('/analytics', [AnalyticsApiController::class, 'index']);
        Route::get('/analytic/{id}', [AnalyticsApiController::class, 'company']);
    });

    Route::middleware(['abilities:companies,edit-company'])->group(function () {
        Route::post('/company/{id}/ban', [CompanyApiController::class, 'ban']);
        Route::post('/company/{id}/unban', [CompanyApiController::class, 'unBan']);
    });
});
