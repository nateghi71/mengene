<?php

namespace App\Http\Middleware;

use App\Models\UserCode;
use Closure;
use Illuminate\Http\Request;

class Check2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->has('randomString'))
        {
            $randomString = session('randomString');
            $userCode = UserCode::where('random_string', $randomString)->first();
//            dd($userCode);
            if (!$userCode || !$userCode->number_verified) {
                return redirect()->route('2fa.index')->with('error', 'مراحل ثبت نام را از اول اغاز کنید.');
            }
        }
        else
        {
            return redirect()->route('2fa.index')->with('error', 'مراحل ثبت نام را از اول اغاز کنید.');
        }

        return $next($request);
    }
}
