<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{

    public function index()
    {
        try {
            $this->authorize('access-business');
        } catch (AuthorizationException $exception) {
            return response()->json(['message' => 'you dont have a business']);
        }
        $user = Auth::user();
        $business = $user->business()->first();
        $userId = Business::where('en_name', $business->en_name)->where('is_accepted', 1)->get()->pluck('user_id')->toArray();
        $users = User::whereIn('id', $userId)->get();
        $businesses = Business::where('en_name', $business->en_name)->get();

        return BusinessResource::collection($businesses);
    }

    public function show(Business $business)
    {
        $user = auth()->user();
        $business = $user->business()->first();
        if ($business && $user->id == $business->user_id) {
            return new BusinessResource($business);
        } else {
            return response()->json(['message' => 'you dont have a business']);
        }
    }

    public function store(Request $request)
    {
        $this->authorize('create', Business::class);

        $request['user_id'] = auth()->id();
        $request['owner_id'] = auth()->id();
        $request['is_accepted'] = 1;
        $request->validate([
            'name' => 'required',
            'en_name' => 'required|unique:businesses',
            'city' => 'required',
            'area' => 'required',
            'address' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $input = $request->all();
        $input['image'] = "/images/" . $imageName;

        $user = auth()->user();
        $business = Business::create($input);
        $user->business_id = $business->id;
        $user->save();

        return new BusinessResource($business);
    }

    public function update(Request $request, Business $business)
    {
        try {
            $this->authorize('access-business');
        } catch (AuthorizationException $exception) {
            return response()->json(['message' => 'you dont own this business']);
        }
        $request->validate([
            'name' => 'required',
            'en_name' => 'required|unique:businesses,en_name,' . $business->id,
            'city' => 'required',
            'area' => 'required',
            'address' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $businesses = Business::where('en_name', $business->en_name)->get();
        foreach ($businesses as $busines) {
            $bis = $request->all();
            if ($cc = $business->customers->first()) {
//            dd($cc->business_en_name);
//                $cc = $business->customers->first();
                $customers = Customer::where('business_en_name', $cc->business_en_name)->get();
                foreach ($customers as $customer) {
//                dd($customer);
                    $customer->business_en_name = $request->en_name;
                    $customer->update();
                }
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $bis['image'] = "/images/" . $imageName;
            $busines->update($bis);
        }
        $showBus = Business::where('id', $business->id)->first();
        return new BusinessResource($showBus);
    }

    public function destroy($businessId)
    {
        $business = Business::where('id', $businessId)->first();

        if ($business->owner_id == $business->user->id && $business->user_id == $business->user->id) {
            $co = Business::where('owner_id', $business->owner_id)->get()->count();
            if ($co <= 1) {
                $user = $business->user;
                $user->business_id = null;
                $user->save();
                $business->delete();
                return response()->json(['message' => 'بیزینس شما با موفقیت حذف شد']);

            }
            return response()->json(['message' => 'قبل از لغو همکاری فرد دیگری را به عنوان مالک تعیین کنید']);
        } elseif ($business->owner_id == auth()->id()) {
            $user = $business->user;
            $user->business_id = null;
            $user->save();
            $business->delete();
            return response()->json(['message' => 'درخواست شما با موفقیت اعمال شد']);
        }
        if ($business->user_id == auth()->id() && $business->owner_id !== auth()->id()) {
            $user = $business->user;
            $user->business_id = null;
            $user->save();
            $business->delete();
            return response()->json(['message' => 'درخواست شما با موفقیت اعمال شد']);
        } else {
            return response()->json(['message' => 'شما نمی توانید مشاورهای دیگر را پاک کنید']);
        }
    }

    public
    function toggleUserAcceptance($businessId)
    {
        $business = Business::where('id', $businessId)->where('owner_id', auth()->user()->id)->first();

        if (!$business) {
            return response()->json(['message' => 'شما نمی توانید مشاور های دیگر را پذیرش کنید']);
        }

        if ($business->is_accepted == 0) {
            $business->is_accepted = 1;
            $business->save();
            return response()->json(['message' => ' مشاور مورد نظر با موفقیت افزوده شد']);

        } else {
            $business->is_accepted = 0;
            $business->save();
            return response()->json(['message' => ' مشاور مورد نظر با موفقیت حذف شد']);

        }

    }

    public function chooseOwner($businessId)
    {
        // Make sure the authenticated user is the owner of the business
        $bis = Business::where('owner_id', auth()->user()->id)->where('id', $businessId)->first();
        $businesses = Business::where('owner_id', auth()->user()->id)->get();

        if ($businesses) {
            foreach ($businesses as $business) {
                if ($business->owner_id == auth()->id())
                    $business->owner_id = $bis->user_id;
                $business->update();
            }
        } else {
            return response()->json(['message' => 'شما نمی توانید این بیزینس را تغییر دهید']);
        }
        return response()->json(['message' => 'مالک جدید با موفقیت انتخاب شد']);
    }
//    public function search(Request $request)
//    {
//        $ownerNumber = $request->owner_number;
//        $business = Business::whereHas('owner', function ($query) use ($ownerNumber) {
//            $query->where('number', $ownerNumber);
//        })->first();
//
//        return BusinessResource::collection($business);
//    }
    public
    function search(Request $request)
    {
        $ownerNumber = $request->query('owner_number');
        $business = Business::whereHas('owner', function ($query) use ($ownerNumber) {
            $query->where('number', $ownerNumber);
        })->first();

        if (!$business) {
            return response()->json(['message' => 'No business found for the given owner number'], 404);
        }
        return new BusinessResource($business);
    }

    public
    function join(Request $request, Business $business)
    {
        $user = auth()->user();
//        dd($business);
        $business = Business::where('id', $business->id)->first();
        $business->created_at = null;
        $business->updated_at = null;
        $business->user_id = $user->id;
        $business->is_accepted = 0;
        $input = $business->toArray();
//        dd($input);

//        $business->members()->attach($user->id);
        // Business joined successfully
        // Add appropriate success response here

        $user->business_id = $business->create($input)->id;
        $user->update();
        return response()->json(['message' => 'درخواست شما ثبت شد و منتظر تایید مالک است']);
    }
}
