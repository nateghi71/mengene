<?php

use App\Http\Controllers\API\BusinessController;
use App\Http\Controllers\API\ConsultantController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\LandownerController;
use App\Http\Controllers\Api\LandownerImageController;
use App\Http\Controllers\API\PremiumController;
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
    Route::get('business/member-acceptance', [BusinessController::class, 'showAcceptedConsultants'])->name('api.business.acceptance');
    Route::get('business/member-notAcceptance', [BusinessController::class, 'showNotAcceptedConsultants'])->name('api.business.notAcceptance');

    Route::put('business/{user}/toggle-user-acceptance', [BusinessController::class, 'toggleUserAcceptance'])->name('api.business.toggleUserAcceptance');
    Route::put('business/{user}/choose-owner', [BusinessController::class, 'chooseOwner'])->name('api.business.chooseOwner');
    Route::get("business/{user}/remove", [BusinessController::class, 'removeMember'])->name('api.business.remove.member');

    Route::post("packages/get_package", [PremiumController::class, 'get_package'])->name('api.packages.get_package');
    Route::get("packages/package_name", [PremiumController::class, 'package_name'])->name('api.packages.package_name');

    Route::get('consultant/index', [ConsultantController::class, 'index'])->name('api.consultant.show');
    Route::post('consultant/search', [ConsultantController::class, 'search'])->name('api.consultant.search');
    Route::post('consultant/join', [ConsultantController::class, 'join'])->name('api.consultant.join');
    Route::get("consultant/{user}/leave", [ConsultantController::class, 'leaveMember'])->name('api.consultant.leave.member');

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
    Route::post('customers/suggestion/block', [SuggestionForCustomerController::class, 'send_block_message'])->name('api.customer.send_block_message');
    Route::post('customer/suggestion/share', [SuggestionForCustomerController::class, 'share_file_with_customer'])->name('api.customer.send_share_message');
    Route::post('customer/remainder/set_time', [CustomerController::class, 'setRemainderTime'])->name('api.customer.remainder');
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
    Route::post('landowners/suggestion/block', [SuggestionForLandOwnerController::class, 'send_block_message'])->name('api.customer.send_block_message');
    Route::post('landowner/suggestion/share', [SuggestionForLandOwnerController::class, 'share_file_with_customer'])->name('api.landowner.send_share_message');
    Route::post('landowner/remainder/set_time', [LandownerController::class, 'setRemainderTime'])->name('api.landowner.remainder');

    Route::get('landowner/subscription/index', [LandownerController::class, 'indexSub'])->name('api.landowner.subscription.index');
    Route::get('landowner/buy/{landowner}', [LandownerController::class, 'buyFile'])->name('api.landowner.buyFile');

//    Route::get('/landowner/images/{landowner}' , [LandownerImageController::class , 'edit'])->name('api.landowner.edit_images');
    Route::post('/landowner/images/add_image' , [LandownerImageController::class , 'add'])->name('api.landowner.add_image');
    Route::post('/landowner/images/delete_image' , [LandownerImageController::class , 'destroy'])->name('api.landowner.delete_image');
});
