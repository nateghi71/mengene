<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function passwordRequest()
    {
        return view('auth.forgot-password');
    }
    public function sendLink(Request $request)
    {
        $request->number = to_english_numbers($request->number);
        $request->validate([
            'number' => 'required|iran_mobile'
        ]);

        $status = Password::sendResetLink(
            $request->only('number')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['message' => 'لینک تغییر پسورد پیامک شد.'])
            : back()->with(['message' => __($status)]);
    }
    public function resetPassword(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }
    public function updatePassword(Request $request)
    {
        $request->number = to_english_numbers($request->number);

        $request->validate([
            'token' => 'required',
            'number' => 'required|iran_mobile',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('number', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('message', 'پسوردتان با موفقیت تغییر یافت.')
            : back()->with(['message' => [__($status)]]);
    }
}
