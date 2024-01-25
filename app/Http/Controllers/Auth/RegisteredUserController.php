<?php

namespace App\Http\Controllers\Auth;

use App\HelperClasses\SmsAPI;
use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Role;
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
    public function twoFANumber()
    {
        return view('auth.twoFAIndex');
    }

    public function twoFACode()
    {
        return view('auth.twoFAConfirm');
    }

    public function twoFAStore(Request $request)
    {
        $request->validate([
            'number' => 'required|iran_mobile|digits:11|unique:users,number'
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
        $smsApi->sendSmsCode($userNumber , $code);

        session()->put('randomString' , $randomString);
        return redirect()->route('2fa.enter_code');
    }

    public function twoFAResend()
    {
        $userCode = UserCode::where('random_string', session('randomString'))->first();
        $previousTimestamp = $userCode->updated_at;

        if ($previousTimestamp->diffInMinutes(now()) >= 2) {
            $userNumber = $userCode->user_number;
            $code = rand(100000, 999999);
            $userCode->update([
                'code' => $code
            ]);

            $smsApi = new SmsAPI();
            $smsApi->sendSmsCode($userNumber , $code);

            return redirect()->route('2fa.enter_code');
        } else {
            // Return an error message indicating that the user needs to wait before requesting a new code

            return redirect()->route('2fa.enter_code')->with('error', 'لطفا دو دقیقه صبر کنید تا ارسال مجدد کد');
        }
    }

    public function twoFAConfirm(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6'
        ]);

        $userCode = UserCode::where('random_string', session('randomString'))->first();

        if (!$userCode) {
            return redirect()->route('2fa.index')->with('error', 'مراحل ثبت نام را از اول اغاز کنید.');
        }

        if ($userCode->code === $request->code) {
            $userCode->update([
                'number_verified' => 1,
            ]);

            return redirect()->route('register');
        }

        return redirect()->route('2fa.enter_code')->with('error', 'کد وارد شده صحیح نیست');
    }

    public function register()
    {

        $provinces = Province::all();
        return view('auth.register' , compact('provinces'));
    }

    public function handle_register(Request $request)
    {
        $userCode = UserCode::where('random_string', session('randomString'))->first();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'city_id' => ['required'],
            'email' => ['nullable' , 'max:255' , 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required'
        ]);

        try {
            DB::beginTransaction();
            $myRole = Role::where('name' , 'user')->first();

            $user = $myRole->users()->create([
                'name' => $request->name,
                'email' => $request->email,
                'number' => $userCode->user_number,
                'city_id' => $request->city_id,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);
            $userCode->delete();
            session()->forget('randomString');

            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error' , 'در دیتابیس خطایی رخ داد.');
        }

        if($request->role == 1)
            return redirect()->route('business.create');
        elseif ($request->role == 0)
            return redirect()->route('consultant.find');
    }
}
