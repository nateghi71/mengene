<?php

use App\Http\Controllers\web\ConsultantController;
use App\Http\Controllers\web\RandomLinkController;
use App\Http\Controllers\web\SuggestionForCustomerController;
use App\Http\Controllers\web\SuggestionForLandOwnerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\CustomerController;
use App\Http\Controllers\web\LandownerController;
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

Route::get('/', function () {
    return view('home');
})->name('welcome');

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard')
    ->middleware('auth');

Route::get('/confirmation/{type}/{token}', [RandomLinkController::class, 'confirmPage'])
    ->middleware('checkRandomLinkExpiration')->name('confirmation.confirmPage');

Route::post('/confirmation/handleExpired', [RandomLinkController::class, 'handleExpired'])->name('confirmation.handle.expired');
Route::post('/confirmation/handleSuggestion', [RandomLinkController::class, 'handleSuggestion'])->name('confirmation.handle.suggestion');

Route::prefix('/packages')->middleware('auth')->group(function () {
    Route::get('/', [PremiumController::class, 'index'])->name('packages.index');
    Route::get('/show', [PremiumController::class, 'show'])->name('packages.show');
    Route::get('/buy', [PremiumController::class, 'create'])->name('packages.buy');
});

Route::middleware('auth')->group(function () {
    Route::resource('business' , BusinessController::class)->except(['show']);
    Route::get('business/{user}/accept', [BusinessController::class, 'toggleUserAcceptance'])->name('business.toggleUserAcceptance');
    Route::get('business/{user}/chooseOwner', [BusinessController::class, 'chooseOwner'])->name('business.chooseOwner');
    Route::get("business/{user}/remove", [BusinessController::class, 'removeMember'])->name('business.remove.member');

    Route::post('consultant/join', [ConsultantController::class, 'join'])->name('consultant.join');
    Route::post('consultant/search', [ConsultantController::class, 'search'])->name('consultant.search');
    Route::get('consultant', [ConsultantController::class, 'index'])->name('consultant.index');
    Route::get('consultant/find', [ConsultantController::class, 'findBusiness'])->name('consultant.find');
    Route::get("consultant/{user}/leave", [ConsultantController::class, 'leaveMember'])->name('consultant.leave.member');

    Route::resource('landowner' , LandownerController::class);
    Route::get('landowner/star/{landowner}', [LandownerController::class, 'star'])->name('landowner.star');
    Route::get('landowner/suggestion/{landowner}', [SuggestionForLandOwnerController::class, 'suggested_customer'])->name('landowner.suggestions');
    Route::post('landowner/suggestion/block', [SuggestionForLandOwnerController::class, 'send_block_message'])->name('landowner.send_block_message');

    Route::resource('customer' , CustomerController::class);
    Route::get('customer/star/{customer}', [CustomerController::class, 'star'])->name('customer.star');
    Route::get('customer/suggestion/{customer}', [SuggestionForCustomerController::class, 'suggested_landowner'])->name('customer.suggestions');
    Route::post('customer/suggestion/block', [SuggestionForCustomerController::class, 'send_block_message'])->name('customer.send_block_message');
});

require __DIR__ . '/auth.php';

