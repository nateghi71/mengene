<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Ghasedak\GhasedakApi;
use http\Env\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\Business;
use App\Http\Controllers\API\MyBaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Business as BusinessResource;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use App\Models\UserCode;

require __DIR__ . '/../../../../vendor/autoload.php';


class BusinessController extends Controller
{
    public function index()
    {
//        $code = rand(100000, 999999);
//        UserCode::updateOrCreate(
//            ['user_id' => auth()->user()->id],
//            ['code' => $code]
//        );
//        $api = new \Ghasedak\GhasedakApi('c882e5b437debd6e6bcb01b345c1ca263b588722fb706cabe5bb76601346bae1');
//        $api->Verify("09331276794", "verification", $code);

        try {
            $this->authorize('access-business');
        } catch (AuthorizationException $exception) {
            return redirect()->route('business.show');
        }
        $user = auth()->user();
        if ($user->isBusinessOwner()) {
            $business = $user->ownedBusiness()->first();
            $members = $business->members()->get();

            return view('business.business', compact('business', 'user', 'members'));

        } elseif ($user->isBusinessMember()) {
            return redirect(route('business.show'));
        }
//        $userId = Business::where('en_name', $business->en_name)->where('is_accepted', 1)->get()->pluck('user_id')->toArray();
//        $users = User::whereIn('id', $userId)->get();
//        $businesses = Business::where('en_name', $business->en_name)->get();
//        dd($businesses);
//        if ($business->owner_id === auth()->id()) {
//            foreach ($businesses as $bis) {
//                if (!$bis->is_accepted) {
//                    $redDot = 1;
//                    view()->composer('layouts.navigation', function ($view) use ($redDot) {
//                        $view->with('redDot', $redDot);
//                    });
//                }
//            }
//        }


//        return view('business.business', compact('business', 'users', 'businesses'));
    }

    public
    function showBusiness()
    {
        $user = auth()->user();
        $business = $user->joinedBusinesses()->first();
        if ($business && $user->id == $business->members()->first()->id) {
            return view('business.businessShow', compact('business'));
        } else {
            return redirect('dashboard');
        }
    }

// Handle the case when there is no requested business
// ...

// Redirect the user to a different page or return an appropriate response
// ...


    public
    function create(Request $request)
    {
//        dd('hello');
        $this->authorize('create', Business::class);

        return view('business.create');
    }

    public
    function store(Request $request)
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
        $input = $request->all();

        if ($request->hasFile('image')) {

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $input['image'] = "/images/" . $imageName;
        }
        $business = Business::create($input);
        return redirect(route('business.index'));
    }

    public
    function edit(Business $business)
    {
        $this->authorize('update', $business);
        return view('business.edit', compact('business'));
    }

    public
    function update(Request $request, Business $business)
    {
        try {
            $this->authorize('access-business');
        } catch (AuthorizationException $exception) {
            return redirect()->route('business.show');
        }

        $request->validate([
            'name' => 'required',
            'en_name' => [
                'required',
                Rule::unique('businesses')->ignore($business->user_id, 'user_id'),
            ],
            'city' => 'required',
            'area' => 'required',
            'address' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
//            $bis->name = $request->all()->name;
//            $bis->en_name = $request->all()->en_name;
//            $bis->image = $request->all()->image;
//            $bis->city = $request->all()->city;
//            $bis->area = $request->all()->area;
//            $bis->address = $request->all()->address;
        if ($cc = $business->customers->first()) {
//            dd($cc->business_en_name);
            $customers = Customer::where('business_en_name', $cc->business_en_name)->get();
            foreach ($customers as $customer) {
//                dd($customer);
                $customer->business_en_name = $request->en_name;
                $customer->update();
            }
        }
        $input = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $input['image'] = "/images/" . $imageName;
        }
        $business->update($input);


        return redirect(route('business.index'));
    }

    public
    function destroy(Business $business)
    {
//        $business = Business::where('id', $businessId)->first();

        if ($business->user_id == auth()->id()) {
            if ($business->members()->first()) {
//                dd($business);
                abort(403, 'قبل از لغو همکاری فرد دیگری را به عنوان مالک تعیین کنید');
            } else {
                $business->delete();
                return redirect()->route('dashboard');
            }

        } else {
            abort(403, 'شما نمی توانید مشاورهای دیگر را حذف کنید');

        }
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
    public
    function toggleUserAcceptance(User $userId)
    {
        // Make sure the authenticated user is the owner of the business
//        dd($userId->joinedBusinesses()->first());
//        $business = $userId->joinedBusinesses()->wherePivot('is_accepted', 1)->first();
        $business = $userId->joinedBusinesses()->first();
        $member = $userId->businessUser()->first();
        if ($business->user_id == auth()->id()) {
            $member->is_accepted = !$member->is_accepted;
            $member->save();
        } else {
            abort(403, 'شما نمی توانید این بیزینس را تغییر دهید');
        }

        return redirect()->route('business.index')->with('success', 'User acceptance has been modified successfully.');
    }

    public
    function chooseOwner(User $userId)
    {
        // Make sure the authenticated user is the owner of the business
        $business = $userId->joinedBusinesses()->first();
        if ($business->user_id == auth()->id()) {
            $business->user_id = $userId->id;
            auth()->user()->joinedBusinesses()->attach($business->id);
            dd($business->joinedBusinesses());
            $business->update();
        } else {
            abort(403, 'شما نمی توانید این بیزینس را تغییر دهید');
        }

        return redirect()->route('business.index')->with('success', 'User acceptance has been modified successfully.');


//        $business->is_accepted = !$business->is_accepted;
//        $business->save();
//
//        return redirect()->route('business.index')->with('success', 'User acceptance has been modified successfully.');
    }

    public
    function search(Request $request)
    {
        $ownerNumber = $request->input('owner_number');
        $business = Business::whereHas('owner', function ($query) use ($ownerNumber) {
            $query->where('number', $ownerNumber);
        })->first();
        return view('business.search', compact('business'));

    }

    public
    function join(Request $request, Business $business)
    {
        $user = auth()->user();
        $business = Business::where('id', $request->business_id)->first();
        $business->created_at = null;
        $business->updated_at = null;
        $business->user_id = $user->id;
        $business->is_accepted = 0;
        $input = $business->toArray();
//        dd($input);
        $user->business_id = $business->create($input)->id;
        $user->save();

        return redirect(route('customers'))->with('success', 'You have successfully joined the business.');
    }
}
