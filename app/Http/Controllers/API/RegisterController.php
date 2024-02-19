<?php

namespace App\Http\Controllers\API;

use App\HelperClasses\SmsAPI;
use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class RegisterController extends Controller
{
    use MyBaseController;

    public function twoFAStore(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'number' => 'required|max:11|digits:11|unique:users,number'
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error', $validator->errors() , 400);
        }

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

        return $this->sendResponse(['random_string' => $randomString], 'Mobile Number accepted successfully.');
    }

    public function twoFAConfirm(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'code' => 'required|digits:6'
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error', $validator->errors() , 400);
        }

        $userCode = UserCode::where('random_string', $request->random_string)->first();

        if (!$userCode) {
            return $this->sendError('verifying Error', 'مراحل ثبت نام را از اول اغاز کنید.', 400);
        }

        if ($userCode->code === $request->code)
        {
            $userCode->update([
                'number_verified' => 1,
            ]);

            return $this->sendResponse(['random_string' => $userCode->random_string], 'code is correct.');
        }

        return $this->sendError('verifying Error', 'کد وارد شده اشتباه هست.' , 400);
    }

    public function twoFAResend(Request $request)
    {
        $userCode = UserCode::where('random_string', $request->random_string)->first();
        $previousTimestamp = $userCode->updated_at;

        if ($previousTimestamp->diffInMinutes(now()) >= 2)
        {
            $userNumber = $userCode->user_number;
            $code = rand(100000, 999999);
            $userCode->update([
                'code' => $code,
            ]);

            $smsApi = new SmsAPI();
            $smsApi->sendSmsCode($userNumber , $code);

            return $this->sendResponse(['random_string' => $userCode->random_string], 'code resend again.');
        }
        else
        {
            // Return an error message indicating that the user needs to wait before requesting a new code
            $this->sendError('Wait Error', 'لطفا دو دقیقه صبر کنید تا ارسال مجدد کد' , 400);
        }
    }

    public function register(Request $request)
    {
        $userCode = UserCode::where('random_string', $request->random_string)->first();
        $data = array();

        if (!$userCode || !$userCode->number_verified) {
            return $this->sendError('Error', 'مراحل ثبت نام را از اول اغاز کنید.' , 400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'city_id' => 'required|string|max:255',
            'email' => 'nullable|max:255',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors() , 400);
        }

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

            $token = $user->createToken('MyApp')->plainTextToken;

            $userCode->delete();
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            return $this->sendError('Database Error', $e->getMessage() , 500);
        }

        return $this->sendResponse(['token' => $token], 'User register successfully.');
    }

    public function login(Request $request)
    {
        $user = User::where('number', $request->number)->first();

        if(!$user)
        {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'] , 401);
        }

        if (Hash::check($request->password , $user->password)) {
            $token = $user->createToken('MyApp')->plainTextToken;
            if($user->ownedBusiness()->exists())
                $role = 'business';
            elseif ($user->joinedBusinesses()->exists())
                $role = 'consultant';
            else
                $role = 'nothing';

            return $this->sendResponse([
                'token' => $token ,
                'role' => $role,
            ], 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised2'] , 400);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->sendResponse([], 'successfully logout.');
    }
}
