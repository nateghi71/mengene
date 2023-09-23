<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\CustomerController;
use App\Http\Controllers\web\LandownerController;
use App\Http\Controllers\web\BusinessController;

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
    return view('welcome');
})->name('welcome');

//Route::get('/dashboard', function () {
//    return view('customer.customers');
//})->middleware(['auth'])->name('dashboard');
Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard')
    ->middleware('auth');


Route::prefix('/customers')->middleware('auth')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers');
    Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::get('/{customer}', [CustomerController::class, 'show'])->name('customer');
    Route::get('/edit/{customer}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::get('/star/{customer}', [CustomerController::class, 'star'])->name('customer.star');
    Route::get('/status/{customer}', [CustomerController::class, 'status'])->name('customer.status');
    Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::post('/update/{customer}', [CustomerController::class, 'update'])->name('customer.update');
    Route::get("/delete/{customer}", [CustomerController::class, 'destroy'])->name('customer.delete');
    Route::get('/forcedelete/{customer}', [CustomerController::class, 'forceDelete'])->name('customer.forcedelete');
    Route::post('/restore/{customer}', [CustomerController::class, 'restore'])->name('customer.restore');
});

Route::prefix('/business')->middleware('auth')->group(function () {
    Route::get('/', [BusinessController::class, 'index'])->name('business.index');
    Route::get('/show', [BusinessController::class, 'showBusiness'])->name('business.show');
    Route::get('/create', [BusinessController::class, 'create'])->name('business.create');
    Route::get('/search', [BusinessController::class, 'search'])->name('business.search');
    Route::post('/join', [BusinessController::class, 'join'])->name('business.join');
    Route::get('/{business}/edit', [BusinessController::class, 'edit'])->name('business.edit');
    Route::get('/{userId}/accept', [BusinessController::class, 'toggleUserAcceptance'])->name('business.toggleUserAcceptance');
    Route::get('/{userId}/chooseOwner', [BusinessController::class, 'chooseOwner'])->name('business.chooseOwner');
    Route::post('/store', [BusinessController::class, 'store'])->name('business.store');
    Route::post('/update/{business}', [BusinessController::class, 'update'])->name('business.update');
    Route::get("/{business}/delete", [BusinessController::class, 'destroy'])->name('business.delete');
    Route::get("/{userId}/remove", [BusinessController::class, 'removeMember'])->name('business.remove.member');
});

Route::prefix('/landowners')->middleware('auth')->group(function () {
    Route::get('/', [LandownerController::class, 'index'])->name('landowners');
    Route::get('/create', [LandownerController::class, 'create'])->name('landowner.create');
    Route::get('/{landowner}', [LandownerController::class, 'show'])->name('landowner');
    Route::get('/edit/{landowner}', [LandownerController::class, 'edit'])->name('landowner.edit');
    Route::get('/star/{landowner}', [LandownerController::class, 'star'])->name('landowner.star');
    Route::get('/status/{landowner}', [LandownerController::class, 'status'])->name('landowner.status');
    Route::post('/store', [LandownerController::class, 'store'])->name('landowner.store');
    Route::post('/update/{landowner}', [LandownerController::class, 'update'])->name('landowner.update');
    Route::get("/delete/{landowner}", [LandownerController::class, 'destroy'])->name('landowner.delete');
    Route::get('/forcedelete/{landowner}', [LandownerController::class, 'forceDelete'])->name('landowner.forcedelete');
    Route::post('/restore/{landowner}', [LandownerController::class, 'restore'])->name('landowner.restore');
});


require __DIR__ . '/auth.php';

