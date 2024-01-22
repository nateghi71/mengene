<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\web\admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::get('/2fa_number', [RegisteredUserController::class, 'twoFANumber'])->name('2fa.enter_number');
    Route::get('/2fa_code', [RegisteredUserController::class, 'twoFACode'])->name('2fa.enter_code');
    Route::post('/2fa_store', [RegisteredUserController::class, 'twoFAStore'])->name('2fa.store');
    Route::post('/2fa_confirm', [RegisteredUserController::class, 'twoFAConfirm'])->name('2fa.confirm');
    Route::get('/2fa_reset', [RegisteredUserController::class, 'twoFAResend'])->name('2fa.resend');
    Route::get('register', [RegisteredUserController::class, 'register'])->middleware('2fa')
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'handle_register'])->middleware('2fa')
        ->name('register.handle');


    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.handle');

    Route::get('admin-panel/login', [UserController::class, 'loginToAdmin'])->name('admin.login');
    Route::post('admin-panel/login', [UserController::class, 'handleLoginToAdmin'])->name('admin.login.handle');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'enter_number_view'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'handle_send'])
        ->name('password.send');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'enter_newPassword_view'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'update_password'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
