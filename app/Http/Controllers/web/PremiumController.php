<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Landowner;
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

require __DIR__ . '/../../../../vendor/autoload.php';


class PremiumController extends Controller
{
    public function index()
    {
//        dd(require __DIR__ . '/../../../../vendor/autoload.php');
        dd('hi');
//        return redirect(route('business.show'));
    }

    public
    function show()
    {
    }


    public
    function store(Request $request)
    {

//        $this->authorize('create', Business::class);
//
//        $request['user_id'] = auth()->id();
//        $request->validate([
//            'name' => 'required',
//            'en_name' => 'required|unique:businesses',
//            'city' => 'required',
//            'area' => 'required',
//            'address' => 'required',
//            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);
//        $input = $request->all();
//
//        if ($request->hasFile('image')) {
//
//            $imageName = time() . '.' . $request->image->extension();
//            $request->image->move(public_path('images'), $imageName);
//            $input['image'] = "/images/" . $imageName;
//        }
//        $business = Business::create($input);
//        $premiumInput['business_id'] = $business->id;
//        $premiumInput['level'] = 'free';
//        $premiumInput['expire_date'] = Carbon::now()->addYear();
//        $premium = Premium::create($premiumInput);
//        return redirect(route('business.index'));
    }

    public
    function edit(Premium $premium)
    {
//        $this->authorize('update', $business);
//        return view('business.edit', compact('business'));
    }

    public
    function update(Request $request, Premium $premium)
    {
//        try {
//            $this->authorize('access-business');
//        } catch (AuthorizationException $exception) {
//            return redirect()->route('business.show');
//        }
//
//        $request->validate([
//            'name' => 'required',
//            'en_name' => [
//                'required',
//                Rule::unique('businesses')->ignore($business->user_id, 'user_id'),
//            ],
//            'city' => 'required',
//            'area' => 'required',
//            'address' => 'required',
//            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);
//
////            $bis->name = $request->all()->name;
////            $bis->en_name = $request->all()->en_name;
////            $bis->image = $request->all()->image;
////            $bis->city = $request->all()->city;
////            $bis->area = $request->all()->area;
////            $bis->address = $request->all()->address;
////        if ($cc = $business->customers->first()) {
////            dd($cc->business_en_name);
////            $customers = Customer::where('business_en_name', $cc->business_en_name)->get();
////            foreach ($customers as $customer) {
////                dd($customer);
////                $customer->business_en_name = $request->en_name;
////                $customer->update();
////            }
////        }
//        $input = $request->all();
//
//        if ($request->hasFile('image')) {
//            $imageName = time() . '.' . $request->image->extension();
//            $request->image->move(public_path('images'), $imageName);
//            $input['image'] = "/images/" . $imageName;
//        }
//        $business->update($input);
//
//
//        return redirect(route('business.index'));
    }

    public
    function destroy(Premium $premium)
    {
////        $business = Business::where('id', $businessId)->first();
//
//        if ($business->user_id == auth()->id()) {
//            if ($business->members()->first()) {
////                dd($business);
//                abort(403, 'قبل از لغو همکاری فرد دیگری را به عنوان مالک تعیین کنید');
//            } else {
//                $business->delete();
//                return redirect()->route('dashboard');
//            }
//
//        } else {
//            abort(403, 'شما نمی توانید بیزینس دیگر را حذف کنید');
//
//        }
    }

//        $this->authorize('delete', $business);

//    public function accept($en_name, $user)
//    {
////        dd($en_name);
////        $this->authorize('update', $business);
//
//        $business = Business::where('en_name', $en_name)->where('user_id', $user)->firstOrFail();
//
//        $isAccepted = $business->is_accepted;
//
//        // Toggle the 'is_accepted' attribute
//        $business->is_accepted = !$isAccepted;
//        $business->save();
//
//        return redirect()->route('business.index');
//    }
}
