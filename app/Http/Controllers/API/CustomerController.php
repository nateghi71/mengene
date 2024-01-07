<?php

namespace App\Http\Controllers\API;

use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\HelperClasses\UpdateStatusFile;
use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\LandownerResource;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Landowner;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends BaseController
{
    public function index()
    {
//        return auth()->user()->joinedBusinesses()->wherePivot('is_accepted', 1)->exists();
        try
        {
            $this->authorize('viewAny' , Customer::class);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'you dont have a business']);
        }

        $user = auth()->user();
        $business = $user->business();

        $customers = $business->customers()->where('status', 'active')
            ->orderBy('is_star', 'desc')->orderBy('expire_date', 'asc')->get();
        $icustomers = $business->customers()->where('status', 'unknown')
            ->orderBy('is_star', 'desc')->orderBy('expire_date', 'asc')->get();

        $indexedCustomers = $customers->groupBy('type_sale');
        $rentCustomers = $indexedCustomers->get('rahn');
        $buyCustomers = $indexedCustomers->get('buy');

        foreach ($customers as $customer) {
            if ($customer->getRawOriginal('expire_date') > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($customer->getRawOriginal('expire_date')) + 1;
                $customer->daysLeft = $daysLeft;
            }
        }

        $indexediCustomers = $icustomers->groupBy('type_sale');
        $rentiCustomers = $indexediCustomers->get('rahn');
        $buyiCustomers = $indexediCustomers->get('buy');

        return $this->sendResponse([
            'customers' => CustomerResource::collection($customers),
            'icustomers' => CustomerResource::collection($icustomers),
            'rentCustomers' => $rentCustomers ? CustomerResource::collection($rentCustomers) : [],
            'rentiCustomers' => $rentiCustomers ? CustomerResource::collection($rentiCustomers) : [],
            'buyCustomers' => $buyCustomers ? CustomerResource::collection($buyCustomers) : [],
            'buyiCustomers' => $buyiCustomers ? CustomerResource::collection($buyiCustomers) : [],
        ], 'Customers retrieved successfully.');
    }

    public function dashboard()
    {
        $user = auth('api')->user();
        return response()->json([$user]);
    }

    public function show(Customer $customer)
    {
        try
        {
            $this->authorize('view' , $customer);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'you dont have a business']);
        }

        return $this->sendResponse([
            'customer' => CustomerResource::collection($customer),
        ],
            'Customer retrieved successfully');
    }

    public function store(Request $request)
    {
        try
        {
            $this->authorize('create' , Customer::class);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'you dont have a business']);
        }

        $request->validate([
            'name' => 'required',
            'number' => 'required|numeric',
            'city' => 'required',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'scale' => 'required|numeric',
            'number_of_rooms' => 'required|numeric',
            'description' => 'required',
            'access_level' => 'required',
            'rahn_amount' => [Rule::requiredIf($request->type_sale == 'rahn') , 'numeric'],
            'rent_amount' => [Rule::requiredIf($request->type_sale == 'rahn') , 'numeric'],
            'selling_price' => [Rule::requiredIf($request->type_sale == 'buy') , 'numeric'],
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'floor_number' => 'required|numeric',
            'is_star' => 'nullable',
            'expire_date' => 'required'
        ]);

//        dd($request->all());
        $user = auth()->user();
        $customer = Customer::create([
            'name' => $request->name,
            'number' => $request->number,
            'city' => $request->city,
            'type_sale' => $request->type_sale,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'scale' => $request->scale,
            'number_of_rooms' => $request->number_of_rooms,
            'description' => $request->description,
            'rahn_amount' => $request->filled('rahn_amount') ? $request->rahn_amount : null,
            'rent_amount' => $request->filled('rent_amount') ? $request->rent_amount : null,
            'selling_price' => $request->filled('selling_price') ? $request->selling_price : null,
            'elevator' => $request->elevator,
            'parking' => $request->parking,
            'store' => $request->store,
            'floor' => $request->floor,
            'floor_number' => $request->floor_number,
            'business_id' => $user->business()->id,
            'user_id' => $user->id,
            'is_star' => $request->is_star,
            'expire_date' => $request->expire_date
        ]);

        return $this->sendResponse(new CustomerResource($customer), 'Customer created successfully.');
    }

    public function update(Request $request, Customer $customer)
    {
        try
        {
            $this->authorize('update' , $customer);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'you dont have a business']);
        }

        $request->validate([
            'name' => 'required',
            'number' => 'required|numeric',
            'city' => 'required',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'scale' => 'required|numeric',
            'number_of_rooms' => 'required|numeric',
            'description' => 'required',
            'access_level' => 'required',
            'rahn_amount' => [Rule::requiredIf($request->type_sale == 'rahn') , 'numeric'],
            'rent_amount' => [Rule::requiredIf($request->type_sale == 'rahn') , 'numeric'],
            'selling_price' => [Rule::requiredIf($request->type_sale == 'buy') , 'numeric'],
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'floor_number' => 'required|numeric',
            'is_star' => 'nullable',
            'expire_date' => 'required'
        ]);

        $customer->update([
            'name' => $request->name,
            'number' => $request->number,
            'city' => $request->city,
            'type_sale' => $request->type_sale,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'scale' => $request->scale,
            'number_of_rooms' => $request->number_of_rooms,
            'description' => $request->description,
            'access_level' => $request->access_level,
            'rahn_amount' => $request->filled('rahn_amount') ? $request->rahn_amount : null,
            'rent_amount' => $request->filled('rent_amount') ? $request->rent_amount : null,
            'selling_price' => $request->filled('selling_price') ? $request->selling_price : null,
            'elevator' => $request->elevator,
            'parking' => $request->parking,
            'store' => $request->store,
            'floor' => $request->floor,
            'floor_number' => $request->floor_number,
//            'business_id' => $user->business()->id,
//            'user_id' => $user->id,
            'is_star' => $request->is_star,
            'expire_date' => $request->expire_date
        ]);

        return $this->sendResponse(new CustomerResource($customer), 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        try
        {
            $this->authorize('delete' , $customer);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'you dont have a business']);
        }
//        dd($customer);

        $customer->delete();

        return $this->sendResponse([], 'Customer deleted successfully.');
    }

    public function star(Customer $customer)
    {
        try
        {
            $this->authorize('update' , $customer);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'you dont have a business']);
        }

        if ($customer->getRawOriginal('is_star') == 0) {
            $customer->is_star = 1;
            $customer->save();
        } else {
            $customer->is_star = 0;
            $customer->save();
        }

        return $this->sendResponse(new CustomerResource($customer), 'Customer star status updated successfully.');
    }

//
//    public function showSuggestions(Customer $customer)
//    {
//        if ($customer->type_sale == 'buy') {
//            $minPrice = $customer->price * 0.8; // 80% of the customer's price
//            $maxPrice = $customer->price * 1.2; // 120% of the customer's price
//
//            $customerId = $customer->id;
//            $suggestions = Landowner::where('status', 'active')
//                ->whereDoesntHave('suggestedCustomer', function ($query) use ($customerId) {
//                    $query->where('customer_id', $customerId);
//                })
//                ->whereBetween('price', [$minPrice, $maxPrice])
//                ->orderBy('price', 'asc')->get();
//
//        } elseif ($customer->type_sale == 'rahn') {
//            //20% diff
//            $minRahn = $customer->rahn * 0.8;
//            $maxRahn = $customer->rahn * 1.2;
//            $minEjareh = $customer->ejareh * 0.8;
//            $maxEjareh = $customer->ejareh * 1.2;
//
//            $customerId = $customer->id;
//            $suggestions = Landowner::where('status', 'active')
//                ->whereDoesntHave('suggestedCustomer', function ($query) use ($customerId) {
//                    $query->where('customer_id', $customerId);
//                })
//                ->whereBetween('rahn', [$minRahn, $maxRahn])
//                ->whereBetween('ejareh', [$minEjareh, $maxEjareh])
//                ->orderBy('rahn', 'asc')
//                ->orderBy('ejareh', 'asc')
//                ->get();
//        }
//        return $this->sendResponse([
//            'Suggestions' => LandownerResource::collection($suggestions),
//        ], 'Suggestions retrieved successfully.');
//    }
}
