<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Token;
use Laravel\Passport\RefreshToken;
use App\Models\UserCode;
use Ghasedak\GhasedakApi;


class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->merge(['number' => Session::get('userNumber')]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'number' => 'required|max:11|digits:11|unique:users,number',
            'city' => 'required|string|max:255',
            'email' => 'max:255',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function twoFAIndex(User $user)
    {
        return response()->json(['message' => 'Two-factor authentication index']);
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
//        $api->Verify($userNumber, $template, $code);

//        $userNumber = ['userNumber' => $uNumber];
//        $request->session()->put($userNumber);
        Session::put('userNumber', $userNumber);
        return response()->json(['userNumber' => $userNumber]);
    }

    public function twoFAResend(Request $request)
    {
//        Session::forget('error');
        $previousCode = UserCode::where('user_number', $request->number)->first();
        $previousTimestamp = $previousCode->updated_at;
        $userNumber = $request->number;
        if ($previousTimestamp->diffInMinutes(now()) >= 2) {
            $code = rand(100000, 999999);
            UserCode::updateOrCreate(
                ['user_number' => $request->number],
                ['code' => $code]
            );
            $template = "verification";
            $api = new GhasedakApi('c882e5b437debd6e6bcb01b345c1ca263b588722fb706cabe5bb76601346bae1');
//            $api->Verify($userNumber, $template, $code);

            return response()->json(['userNumber' => $userNumber]);
        } else {
            // Return an error message indicating that the user needs to wait before requesting a new code
            return response()->json(['error' => 'Please wait for 2 minutes before requesting a new code']);
        }
    }

    public function twoFAConfirm(Request $request)
    {
//        dd($request->session()->get('userNumber'));
//        dd(Session::get('userNumber'));
        Session::forget('error');
        $userNumber = Session::get('userNumber');
        $code = UserCode::where('user_number', $userNumber)->pluck('code')->pop();

        if ($code === $request->code) {
            Session::put('user_2fa', 'allowed');
            Session::put('userNumber', $userNumber);

            return response()->json(['userNumber' => $userNumber]);
        }

        return response()->json(['error' => 'Invalid verification code']);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['number' => $request->number, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

//    public function logout()
//    {
//        if (Auth::check()) {
//            Auth::user()->AauthAcessToken()->delete();
//        }
//    }

    public function logout()
    {
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
        return response()->json([
            'message' => 'successfuly logout'
        ]);
    }
}
