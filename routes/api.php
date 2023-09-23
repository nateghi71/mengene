<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\LandownerController;
use App\Http\Controllers\API\BusinessController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('2fa')->group(function () {
    Route::get('/', [RegisterController::class, 'twoFAIndex'])->name('api.2fa.index');
    Route::post('/store', [RegisterController::class, 'twoFAStore'])->name('api.2fa.store');
    Route::post('/confirm', [RegisterController::class, 'twoFAConfirm'])->name('api.2fa.confirm');
    Route::post('/reset', [RegisterController::class, 'twoFAResend'])->name('api.2fa.resend');
});

Route::post('register', [RegisterController::class, 'register'])->middleware('2fa');
Route::post('login', [RegisterController::class, 'login']);
Route::post('logout', [RegisterController::class, 'logout'])->middleware('auth:api');
//$router->group(['middleware' => 'auth:api'], function () use ($router) {
//    Route::get('logout', [RegisterController::class, 'logout']);
//});
Route::middleware('auth:api')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('api.dashboard');

    Route::resource('customers', CustomerController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy'])
        ->names([
            'index' => 'api.customers',
            'store' => 'api.customer.store',
            'show' => 'api.customer.show',
            'update' => 'api.customer.update',
            'destroy' => 'api.customer.delete',
        ]);

    Route::put('/customers/{customer}/star', [CustomerController::class, 'star'])->name('api.customer.star');
    Route::put('/customers/{customer}/status', [CustomerController::class, 'status'])->name('api.customer.status');
});

Route::middleware('auth:api')->group(function () {
    Route::resource('business', BusinessController::class)->except([
        'create', 'edit'
    ])->names([
        'index' => 'api.business.index',
        'show' => 'api.business.show',
        'store' => 'api.business.store',
        'update' => 'api.business.update',
        'destroy' => 'api.business.destroy',
    ]);

    // Additional routes
    Route::put('business/{business}/toggle-user-acceptance', [BusinessController::class, 'toggleUserAcceptance'])->name('api.business.toggleUserAcceptance');
    Route::put('business/{business}/choose-owner', [BusinessController::class, 'chooseOwner'])->name('api.business.chooseOwner');
    Route::post('business/search', [BusinessController::class, 'search'])->name('api.business.search');
    Route::post('business/{business}/join', [BusinessController::class, 'join'])->name('api.business.join');
});


Route::middleware('auth:api')->group(function () {
    Route::resource('landowners', LandownerController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy'])
        ->names([
            'index' => 'api.landowners',
            'store' => 'api.landowner.store',
            'show' => 'api.landowner.show',
            'update' => 'api.landowner.update',
            'destroy' => 'api.landowner.delete',
        ]);

    Route::put('/landowners/{landowner}/star', [LandownerController::class, 'star'])->name('api.landowner.star');
    Route::put('/landowners/{landowner}/status', [LandownerController::class, 'status'])->name('api.landowner.status');
});
