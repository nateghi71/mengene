<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserCode;
use App\Providers\RouteServiceProvider;
use Ghasedak\GhasedakApi;
use http\Message;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    public function twoFAIndex(User $user)
    {
        return view('auth.twoFAIndex');
    }

    public function twoFAStore(Request $request)
    {
        $number = User::where('number', $request->number)->pluck('number')->pop();
        $request->validate([
            'number' => ['required', 'string', 'max:11', 'unique:users'],
        ]);

        $userNumber = $request->number;
        $code = rand(100000, 999999);
        UserCode::updateOrCreate(
            ['user_number' => $request->number],
            ['code' => $code]
        );
        $template = "verification";
        $api = new GhasedakApi('c882e5b437debd6e6bcb01b345c1ca263b588722fb706cabe5bb76601346bae1');
        $api->Verify($userNumber, $template, $code);

        return view('auth.twoFAConfirm', compact('userNumber'));

    }

    public
    function twoFAResend(Request $request)
    {
        Session::forget('error');
        $previousCode = UserCode::where('user_number', $request->userNumber)->first();
        $previousTimestamp = $previousCode->updated_at;
        $userNumber = $request->userNumber;
        if ($previousTimestamp->diffInMinutes(now()) >= 2) {
            $code = rand(100000, 999999);
            UserCode::updateOrCreate(
                ['user_number' => $request->userNumber],
                ['code' => $code]
            );
            $template = "verification";
            $api = new GhasedakApi('c882e5b437debd6e6bcb01b345c1ca263b588722fb706cabe5bb76601346bae1');
            $api->Verify($userNumber, $template, $code);
            return view('auth.twoFAConfirm', compact('userNumber'));
        } else {
            // Return an error message indicating that the user needs to wait before requesting a new code
            Session::put('error', 'لطفا دو دقیقه صبر کنید تا ارسال مجدد کد');
            return view('auth.twoFAConfirm', compact('userNumber'));
        }
    }

    public
    function twoFAConfirm(Request $request)
    {
        Session::forget('error');
        $code = UserCode::where('user_number', $request->userNumber)->pluck('code')->pop();
        $userNumber = $request->userNumber;

        if ($code === $request->code) {
            Session::put('user_2fa', 'allowed');
            Session::put('userNumber', $userNumber);

            return redirect()->route('register');

        }
        Session::put('error', 'کد وارد شده صحیح نیست');
        return view('auth.twoFAConfirm', compact('userNumber'));

    }


    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public
    function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'email' => ['max:255'],
            'number' => ['required', 'string', 'max:11', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::create([
            'name' => $request->name,
            'city' => $request->city,
            'number' => $request->number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
        $oldCode = UserCode::where('user_number', $request->number)->first();
        $oldCode->delete();

        return redirect('/dashboard');
    }
}
