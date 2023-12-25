<?php

use App\Http\Controllers\API\BusinessController;
use App\Http\Controllers\Api\ConsultantController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\LandownerController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\SuggestionForCustomerController;
use App\Http\Controllers\API\SuggestionForLandownerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('logout', [RegisterController::class, 'logout'])->middleware('auth:sanctum');

Route::post('2fa/store', [RegisterController::class, 'twoFAStore'])->name('api.2fa.store');
Route::post('2fa/confirm', [RegisterController::class, 'twoFAConfirm'])->name('api.2fa.confirm');
Route::post('2fa/resend', [RegisterController::class, 'twoFAResend'])->name('api.2fa.resend');
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('business', BusinessController::class)->except([
        'show'
    ])->names([
        'index' => 'api.business.index',
        'store' => 'api.business.store',
        'update' => 'api.business.update',
        'destroy' => 'api.business.destroy',
    ]);

    // Additional routes
    Route::put('business/{user}/toggle-user-acceptance', [BusinessController::class, 'toggleUserAcceptance'])->name('api.business.toggleUserAcceptance');
    Route::put('business/{user}/choose-owner', [BusinessController::class, 'chooseOwner'])->name('api.business.chooseOwner');
    Route::get("business/{user}/remove", [BusinessController::class, 'removeMember'])->name('api.business.remove.member');

    Route::get('consultant/index', [ConsultantController::class, 'index'])->name('api.consultant.show');
    Route::post('consultant/search', [ConsultantController::class, 'search'])->name('api.consultant.search');
    Route::post('consultant/join', [ConsultantController::class, 'join'])->name('api.consultant.join');
    Route::get("consultant/{user}/leave", [ConsultantController::class, 'leaveMember'])->name('api.consultant.leave.member');

    Route::post("business/{business}/performingPremium", [BusinessController::class, 'performingPremium'])->name('api.business.performingPremium');
});


//$router->group(['middleware' => 'auth:api'], function () use ($router) {
//    Route::get('logout', [RegisterController::class, 'logout']);
//});
Route::middleware('auth:api')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('api.dashboard');

    Route::apiResource('customers', CustomerController::class)
        ->names([
            'index' => 'api.customers',
            'store' => 'api.customer.store',
            'show' => 'api.customer.show',
            'update' => 'api.customer.update',
            'destroy' => 'api.customer.delete',
        ]);

    Route::put('/customers/{customer}/star', [CustomerController::class, 'star'])->name('api.customer.star');
    Route::get('customers/suggestion/{customer}', [SuggestionForCustomerController::class, 'suggested_landowner'])->name('api.customer.suggestions');
    Route::post('customers/suggestion/block', [SuggestionForCustomerController::class, 'send_block_message'])->name('customer.send_block_message');

});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('landowners', LandownerController::class)
        ->names([
            'index' => 'api.landowners',
            'store' => 'api.landowner.store',
            'show' => 'api.landowner.show',
            'update' => 'api.landowner.update',
            'destroy' => 'api.landowner.delete',
        ]);

    Route::put('/landowners/{landowner}/star', [LandownerController::class, 'star'])->name('api.landowner.star');
    Route::get('landowners/suggestion/{landowner}', [SuggestionForLandOwnerController::class, 'suggested_customer'])->name('api.landowner.suggestions');
    Route::post('landowners/suggestion/block', [SuggestionForLandOwnerController::class, 'send_block_message'])->name('customer.send_block_message');
});
