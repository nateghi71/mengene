<?php

namespace App\Http\Controllers\Auth;

use App\HelperClasses\SmsAPI;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserCode;
use App\Providers\RouteServiceProvider;
use http\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;


class RegisteredUserController extends Controller
{
    public function twoFAIndex(User $user)
    {
//        Session::put('user_2fa', 'allowed');
//        Session::put('userNumber', rand(10000000000, 99999999999));
//        return view('auth.register');

        return view('auth.twoFAIndex');
    }

    public function twoFAStore(Request $request)
    {
        $request->validate([
            'number' => 'required|max:11|digits:11'
        ]);

        $userNumber = $request->number;
        $code = rand(100000, 999999);
        $randomString = Str::random(12);

        UserCode::create([
            'user_number' => $userNumber,
            'code' => $code,
            'number_verified' => 0,
            'random_string' => $randomString,
        ]);

        $smsApi = new SmsAPI();
        $smsApi->sendSms($userNumber , $code);

        return view('auth.twoFAConfirm', compact('randomString'));
    }

    public function twoFAResend(Request $request)
    {
        Session::forget('error');
        $userCode = UserCode::where('random_string', $request->random_string)->first();
        $previousTimestamp = $userCode->updated_at;
        $randomString = $userCode->random_string;

        if ($previousTimestamp->diffInMinutes(now()) >= 2) {
            $userNumber = $userCode->user_number;
            $code = rand(100000, 999999);
            $userCode->update([
                'code' => $code
            ]);

            $smsApi = new SmsAPI();
            $smsApi->sendSms($userNumber , $code);

            return view('auth.twoFAConfirm', compact('randomString'));
        } else {
            // Return an error message indicating that the user needs to wait before requesting a new code
            Session::put('error', 'لطفا دو دقیقه صبر کنید تا ارسال مجدد کد');
            return view('auth.twoFAConfirm', compact('randomString'));
        }
    }

    public function twoFAConfirm(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6'
        ]);

        Session::forget('error');
        $userCode = UserCode::where('random_string', $request->random_string)->first();

        if (!$userCode) {
            return redirect()->route('2fa.index')->with('error', 'مراحل ثبت نام را از اول اغاز کنید.');
        }

        $randomString = $userCode->random_string;

        if ($userCode->code === $request->code) {
            $userCode->update([
                'number_verified' => 1,
            ]);

            session()->put('randomString' , $randomString);
            return redirect()->route('register');
        }
        Session::put('error', 'کد وارد شده صحیح نیست');
        return view('auth.twoFAConfirm', compact('randomString'));
    }

    public function register()
    {
        return view('auth.register');
    }

    public function handle_register(Request $request)
    {
        $userCode = UserCode::where('random_string', session('randomString'))->first();
        session()->forget('randomString');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'email' => ['max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'number' => $userCode->user_number,
                'city' => $request->city,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);

            $userCode->delete();

            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error' , 'در دیتابیس خطایی رخ داد.');
        }

        return redirect()->route('dashboard');
    }
}
