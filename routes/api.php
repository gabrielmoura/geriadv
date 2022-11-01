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
use App\Http\Controllers\Import\ImportCCAController;
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

Route::prefix('v1')->group(function () {

    Route::post('/authorization', function (Request $request) {
        $request->validate(['email' => 'required|email', 'password' => 'required|min:5']);
        try {
            $auth = auth();
            if ($auth->attempt($request->only('email', 'password'))) {
                $user = $auth->user();

                if (!$user->hasPermissionTo('use_api')) return response(null, 401);
//
                if ($user->hasRole('admin')) {
                    $ability = ['admin', 'clients', 'lawyer', 'employer', 'companies', 'edit-company', 'analytics', 'users'];
                } else {
                    $ability = ['analytics'];
                }

                $token = $auth->user()->createToken('Token Api', $ability);
                return ['token' => $token->plainTextToken];
            } else {
                return response()->json(['error' => __('error.Unauthorized')], 401);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    })->block();


    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware(['ability:analytics'])->group(function () {
            Route::get('/analytics', [AnalyticsApiController::class, 'index']);
            Route::get('/analytic/{id}', [AnalyticsApiController::class, 'company']);
        });

        //  Retorna todos os dados do usuário atual
        Route::get('/me', function (Request $request) {
            return $request->user()->load('tokens');
        });

        //  Revoga token em uso
        Route::post('/auth/revoke', function (Request $request) {
            return $request->user()->currentAccessToken()->delete() ? response()->json('ok') : abort(400, __('error.NotAllowed'));
        });

        //  Revoga todos os tokens
        Route::post('/auth/warning', function (Request $request) {
            return $request->user()->tokens()->delete() ? response()->json('ok') : abort(400, __('error.NotAllowed'));
        });

        Route::prefix('/admin')->group(function () {
            //  Autoriza usuário[email,id] a solicitar token
            Route::middleware(['ability:admin'])->group(function () {
                Route::post('permissionTo', [UserApiController::class, 'permissionTo']);
                Route::post('/userAdmin', [UserApiController::class, 'storeAdmin']);
            });


            Route::middleware(['ability:clients'])->group(function () {
                Route::get('/clients', [ClientApiController::class, 'index']);
                Route::get('/client/{id}', [ClientApiController::class, 'show']);
            });

            Route::middleware(['ability:users'])->group(function () {
                Route::get('/users', [UserApiController::class, 'index']);
                Route::get('/user/{id}', [UserApiController::class, 'show']);
                Route::post('/userAdmin', [UserApiController::class, 'storeAdmin']);
                Route::patch('/user/{id}', [UserApiController::class, 'update']);
            });

            Route::middleware(['ability:users,lawyer'])->group(function () {
                Route::get('/lawyers', [LawyerApiController::class, 'index']);
                Route::get('/lawyer/{id}', [LawyerApiController::class, 'show']);
            });

            Route::middleware(['ability:users,employer'])->group(function () {
                Route::get('/employers', [EmployerApiController::class, 'index']);
                Route::get('/employer/{id}', [EmployerApiController::class, 'show']);
                Route::post('/employer', [EmployerApiController::class, 'store']);
                Route::post('/employer/ban', [EmployerApiController::class, 'ban']);
                Route::post('/employer/unban', [EmployerApiController::class, 'unBan']);
                Route::patch('/employer/{id}', [EmployerApiController::class, 'update']);
            });

            Route::middleware(['ability:companies'])->group(function () {
                Route::get('/companies', [CompanyApiController::class, 'index']);
                Route::post('/company', [CompanyApiController::class, 'show']);
                Route::post('/company', [CompanyApiController::class, 'store']);
                Route::patch('/company/{id}', [CompanyApiController::class, 'update']);
            });
            Route::middleware(['abilities:companies,edit-company'])->group(function () {
                Route::post('/company/ban', [CompanyApiController::class, 'ban']);
                Route::post('/company/unban', [CompanyApiController::class, 'unBan']);
            });
            Route::post('/import', [ImportCCAController::class, 'store']);
        });
    });

});
