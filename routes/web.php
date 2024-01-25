<?php

use App\Http\Controllers\web\admin\RoleController;
use App\Http\Controllers\web\admin\UserController;
use App\Http\Controllers\web\admin\BusinessController as AdminBusinessController;
use App\Http\Controllers\web\ConsultantController;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\LandownerImageController;
use App\Http\Controllers\web\RandomLinkController;
use App\Http\Controllers\web\SpecialLandownerController;
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

Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('public_landowner', [HomeController::class, 'public_landowners'])->name('landowner.public.index');
Route::get('public_landowner/{landowner}', [HomeController::class, 'show_public_landowners'])->name('landowner.public.show');
Route::get('public_customer', [HomeController::class, 'public_customers'])->name('customer.public.index');
Route::get('public_customer/{customer}', [HomeController::class, 'show_public_customers'])->name('customer.public.show');
Route::get('/get-province-cities-list', [HomeController::class, 'getProvinceCitiesList']);

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', [BusinessController::class, 'dashboard'])->name('dashboard')
    ->middleware('auth');

Route::get('/confirmation/{type}/{token}', [RandomLinkController::class, 'confirmPage'])
    ->middleware('checkRandomLinkExpiration')->name('confirmation.confirmPage');

Route::post('/confirmation/handleExpired', [RandomLinkController::class, 'handleExpired'])->name('confirmation.handle.expired');
Route::post('/confirmation/handleSuggestion', [RandomLinkController::class, 'handleSuggestion'])->name('confirmation.handle.suggestion');

Route::prefix('/packages')->middleware('auth')->group(function () {
    Route::get('/', [PremiumController::class, 'index'])->name('packages.index');
    Route::post('/store', [PremiumController::class, 'store'])->name('packages.store');
    Route::post('/update', [PremiumController::class, 'update'])->name('packages.update');
});

Route::middleware('auth')->group(function () {
    Route::resource('business' , BusinessController::class)->except(['show']);
    Route::get('business/{user}/accept', [BusinessController::class, 'toggleUserAcceptance'])->name('business.toggleUserAcceptance');
    Route::get('business/{user}/chooseOwner', [BusinessController::class, 'chooseOwner'])->name('business.chooseOwner');
    Route::get("business/{user}/remove", [BusinessController::class, 'removeMember'])->name('business.remove.member');
    Route::get("business/consultants", [BusinessController::class, 'showConsultants'])->name('business.consultants');

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

    Route::get('landowner/subscription/index', [LandownerController::class, 'indexSub'])->name('landowner.subscription.index');
    Route::get('landowner/buy/{landowner}', [LandownerController::class, 'buyFile'])->name('landowner.buyFile');

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
});

Route::middleware('auth')->prefix('admin-panel')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->except(['destroy']);
    Route::resource('roles', RoleController::class);
    Route::resource('landowners', FileController::class);
    Route::get('/landowners/images/{landowner}' , [FileController::class , 'editImage'])->name('landowner.edit_images');
    Route::get('users/change_status/{user}' , [UserController::class , 'changeStatus'])->name('users.status');
    Route::get('/' , [AdminBusinessController::class , 'adminPanel'])->name('adminPanel');
    Route::get('business' , [AdminBusinessController::class , 'index'])->name('business.index');
    Route::get('business/{business}' , [AdminBusinessController::class , 'show'])->name('business.show');
    Route::get('business/change_status/{business}' , [AdminBusinessController::class , 'changeStatus'])->name('business.changeStatus');
});


require __DIR__ . '/auth.php';

