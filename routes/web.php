<?php

use App\Http\Controllers\web\admin\CouponController;
use App\Http\Controllers\web\admin\OrderController;
use App\Http\Controllers\web\admin\RoleController;
use App\Http\Controllers\web\admin\UserController as AdminUserController;
use App\Http\Controllers\web\admin\BusinessController as AdminBusinessController;
use App\Http\Controllers\web\ConsultantController;
use App\Http\Controllers\web\CreditController;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\LandownerImageController;
use App\Http\Controllers\web\PaymentController;
use App\Http\Controllers\web\ProfileController;
use App\Http\Controllers\web\RandomLinkController;
use App\Http\Controllers\web\RentContractController;
use App\Http\Controllers\web\SuggestionForCustomerController;
use App\Http\Controllers\web\SuggestionForLandOwnerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\CustomerController;
use App\Http\Controllers\web\LandownerController;
use App\Http\Controllers\web\admin\FileController;
use App\Http\Controllers\web\BusinessController;
use App\Http\Controllers\web\PremiumController;

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
Route::get('/confirmation/{type}/{token}', [RandomLinkController::class, 'confirmPage'])
    ->middleware('checkRandomLinkExpiration')->name('confirmation.confirmPage');
Route::post('/confirmation/handleExpired', [RandomLinkController::class, 'handleExpired'])->name('confirmation.handle.expired');
Route::post('/confirmation/handleSuggestion', [RandomLinkController::class, 'handleSuggestion'])->name('confirmation.handle.suggestion');
Route::get('/payment/verify/{price}', [PaymentController::class, 'paymentVerify'])->name('payment.verify');

Route::middleware('auth')->group(function (){
    Route::get('packages/checkout', [PremiumController::class, 'checkout'])->name('packages.checkout');
    Route::post('/check-coupon', [PremiumController::class, 'applyCoupon'])->name('coupon.apply');
    Route::post('/payment/buy_package', [PaymentController::class, 'payment_for_package'])->name('payment.package');
    Route::post('/payment/buy_file', [PaymentController::class, 'payment_for_file'])->name('payment.file');
    Route::post('/payment/buy_credit', [PaymentController::class, 'payment_for_credit'])->name('payment.credit');
});

Route::middleware('clearCoupon')->group(function (){
Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('public_landowner', [HomeController::class, 'public_landowners'])->name('landowner.public.index');
Route::get('public_landowner/{landowner}', [HomeController::class, 'show_public_landowners'])->name('landowner.public.show');
Route::get('public_customer', [HomeController::class, 'public_customers'])->name('customer.public.index');
Route::get('public_customer/{customer}', [HomeController::class, 'show_public_customers'])->name('customer.public.show');
Route::get('/get-province-cities-list', [HomeController::class, 'getProvinceCitiesList']);
});

Route::group(['middleware' => ['auth', 'clearCoupon']] , function () {
    Route::resource('business' , BusinessController::class)->except(['show']);
    Route::get('business/{user}/accept', [BusinessController::class, 'toggleUserAcceptance'])->name('business.toggleUserAcceptance');
    Route::get('business/{user}/chooseOwner', [BusinessController::class, 'chooseOwner'])->name('business.chooseOwner');
    Route::get("business/{user}/remove", [BusinessController::class, 'removeMember'])->name('business.remove.member');
    Route::get("business/consultants", [BusinessController::class, 'showConsultants'])->name('business.consultants');
    Route::get('/dashboard', [BusinessController::class, 'dashboard'])->name('dashboard');
    Route::get('/notification/{notification}', [BusinessController::class, 'notificationRead'])->name('business.notificationRead');

    Route::get("profile/edit_user", [ProfileController::class, 'edit_user'])->name('profile.edit_user');
    Route::post("profile/update_user", [ProfileController::class, 'update_user'])->name('profile.update_user');
    Route::get("profile/edit_password", [ProfileController::class, 'edit_password'])->name('profile.edit_password');
    Route::post("profile/update_password", [ProfileController::class, 'update_password'])->name('profile.update_password');

    Route::get("credits", [CreditController::class, 'index'])->name('credits.index');
    Route::post("credits/checkout", [CreditController::class, 'checkout'])->name('credits.checkout');

    Route::get('packages', [PremiumController::class, 'index'])->name('packages.index');
    Route::post('packages/get_package', [PremiumController::class, 'get_package'])->name('packages.get_package');

    Route::get('subscription/index', [LandownerController::class, 'indexSub'])->name('landowner.subscription.index');
    Route::post('subscription/checkout', [LandownerController::class, 'checkout'])->name('landowner.subscription.checkout');

    Route::post('consultant/join', [ConsultantController::class, 'join'])->name('consultant.join');
    Route::post('consultant/search', [ConsultantController::class, 'search'])->name('consultant.search');
    Route::get('consultant', [ConsultantController::class, 'index'])->name('consultant.index');
    Route::get('consultant/find', [ConsultantController::class, 'findBusiness'])->name('consultant.find');
    Route::get("consultant/{user}/leave", [ConsultantController::class, 'leaveMember'])->name('consultant.leave.member');

    Route::resource('landowner' , LandownerController::class)->except('index');
    Route::get('landowner', [LandownerController::class, 'index'])->name('landowner.index');
    Route::get('landowner/star/{landowner}', [LandownerController::class, 'star'])->name('landowner.star');
    Route::get('landowner/suggestion/{landowner}', [SuggestionForLandOwnerController::class, 'suggested_customer'])->name('landowner.suggestions');
    Route::post('landowner/suggestion/block', [SuggestionForLandOwnerController::class, 'send_block_message'])->name('landowner.send_block_message');
    Route::post('landowner/suggestion/share', [SuggestionForLandOwnerController::class, 'share_file_with_customer'])->name('landowner.send_share_message');
    Route::post('landowner/remainder/set_time', [LandownerController::class, 'setRemainderTime'])->name('landowner.remainder');

    Route::get('/landowner/images/{landowner}' , [LandownerImageController::class , 'edit'])->name('landowner.edit_images');
    Route::post('/landowner/images/add_image' , [LandownerImageController::class , 'add'])->name('landowner.add_image');
    Route::post('/landowner/images/delete_image' , [LandownerImageController::class , 'destroy'])->name('landowner.delete_image');

    Route::resource('customer' , CustomerController::class)->except('index');
    Route::get('customer', [CustomerController::class, 'َََََindex'])->name('customer.index');
    Route::get('customer/star/{customer}', [CustomerController::class, 'star'])->name('customer.star');
    Route::get('customer/suggestion/{customer}', [SuggestionForCustomerController::class, 'suggested_landowner'])->name('customer.suggestions');
    Route::post('customer/suggestion/block', [SuggestionForCustomerController::class, 'send_block_message'])->name('customer.send_block_message');
    Route::post('customer/suggestion/share', [SuggestionForCustomerController::class, 'share_file_with_customer'])->name('customer.send_share_message');
    Route::post('customer/remainder/set_time', [CustomerController::class, 'setRemainderTime'])->name('customer.remainder');

    Route::resource('rent_contracts' , RentContractController::class);
});

Route::middleware('auth')->prefix('admin-panel')->name('admin.')->group(function () {
    Route::resource('users', AdminUserController::class)->except(['destroy']);
    Route::resource('roles', RoleController::class);
    Route::resource('landowners', FileController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('orders', OrderController::class);
    Route::get('/landowners/images/{landowner}' , [FileController::class , 'editImage'])->name('landowner.edit_images');
    Route::get('users/change_status/{user}' , [AdminUserController::class , 'changeStatus'])->name('users.status');
    Route::get('/' , [AdminBusinessController::class , 'adminPanel'])->name('adminPanel');
    Route::get('business' , [AdminBusinessController::class , 'index'])->name('business.index');
    Route::get('business/{business}' , [AdminBusinessController::class , 'show'])->name('business.show');
    Route::get('business/change_status/{business}' , [AdminBusinessController::class , 'changeStatus'])->name('business.changeStatus');
});

require __DIR__ . '/auth.php';

