<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Landowner;
use App\Models\Order;
use App\Models\Package;
use App\Models\Premium;
use App\Models\User;
use Carbon\Carbon;
use Ghasedak\GhasedakApi;
use http\Env\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use App\Models\UserCode;
use Ramsey\Uuid\Generator\PeclUuidNameGenerator;

class PremiumController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('premium.index' , compact('packages'));
    }

    public function get_package(Request $request)
    {
        $request->validate([
            'package_name' => 'required',
        ]);

        session()->put('package_name' , $request->package_name);
        return redirect()->route('packages.checkout');
    }
    public function checkout()
    {
        if(!session()->has('package_name'))
            return redirect()->route('packages.index');

        $package = Package::where('name' , session('package_name'))->first();
        $package->coupon_amount = session()->has('coupon') ? session('coupon.amount') : 0;
        $package->walletCharge = 50000;
        $package->tax = (($package->price + $package->walletCharge) - $package->coupon_amount) * 0.09;
        $package->payment = (($package->price + $package->walletCharge) - $package->coupon_amount) + $package->tax;
        return view('premium.checkout' , compact('package'));
    }

    public function store($business)
    {
        $package = Package::where('name' , 'free')->first();
        $business->premium()->create([
            'package_id' => $package->id,
            'expire_date' => Carbon::now()->addMonth($package->time),
        ]);
    }
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        if (!auth()->check())
            return back()->with('message' , 'برای استفاده از کد تخفیف نیاز هست ابتدا وارد وب سایت شوید');

        $result = checkCoupon($request->code);
        if (array_key_exists('error', $result)) {
            return back()->with('message' , $result['error']);
        }

        $coupon = $result['coupon'] ;

        $amount = floor(($request->amount * $coupon->percentage / 100)/1000)*1000;
        session()->put('coupon', ['id' => $coupon->id, 'code' => $coupon->code, 'amount' => $amount]);

        return back()->with('message' , 'کد تخفیف برای شما ثبت شد');
    }
}
