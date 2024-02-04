<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit_user()
    {
        $provinces = Province::all();
        $user = auth()->user();
        return view('business.edit_user' , compact('user' , 'provinces'));
    }
    public function update_user(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|iran_mobile|digits:11',
            'city_id' => 'required',
            'email' => 'nullable|max:255|email',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'city_id' => $request->city_id,
        ]);

        return redirect()->route('dashboard')->with('message' , 'پروفایل شما با موفقیت ویرایش شد.');
    }
    public function edit_password()
    {
        return view('business.change_password');
    }
    public function update_password(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if(Hash::check($request->old_password , $user->password))
        {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            return redirect()->route('dashboard')->with('message' , 'رمز ورود شما با موفقیت تغییر کرد.');
        }

        return back()->with('message' , 'رمز ورود فعلی وارد شده اشتباه می باشد.');
    }


}
