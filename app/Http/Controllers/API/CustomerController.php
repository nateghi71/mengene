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
            if ($customer->expire_date > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($customer->expire_date) + 1;
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
            'number' => 'required',
            'city' => 'required',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'scale' => 'required',
            'number_of_rooms' => 'required',
            'description' => 'required',
            'rahn_amount' => 'nullable',
            'rent_amount' => 'nullable',
            'selling_price' => 'nullable',
            'elevator' => 'required',
            'parking' => 'required',
            'store' => 'required',
            'floor_number' => 'required',
            'is_star' => 'required',
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
            'rahn_amount' => $request->has('rahn_amount') ? $request->rahn_amount : null,
            'rent_amount' => $request->has('rent_amount') ? $request->rent_amount : null,
            'selling_price' => $request->has('selling_price') ? $request->selling_price : null,
            'elevator' => $request->elevator,
            'parking' => $request->parking,
            'store' => $request->store,
            'floor' => $request->floor,
            'floor_number' => $request->floor_number,
            'business_id' => $user->business()->first()->id,
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
            'number' => 'required',
            'city' => 'required',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'scale' => 'required',
            'number_of_rooms' => 'required',
            'description' => 'required',
            'rahn_amount' => 'nullable',
            'rent_amount' => 'nullable',
            'selling_price' => 'nullable',
            'elevator' => 'required',
            'parking' => 'required',
            'store' => 'required',
            'floor_number' => 'required',
            'is_star' => 'required',
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
            'rahn_amount' => $request->has('rahn_amount') ? $request->rahn_amount : null,
            'rent_amount' => $request->has('rent_amount') ? $request->rent_amount : null,
            'selling_price' => $request->has('selling_price') ? $request->selling_price : null,
            'elevator' => $request->elevator,
            'parking' => $request->parking,
            'store' => $request->store,
            'floor' => $request->floor,
            'floor_number' => $request->floor_number,
//            'business_id' => $user->business()->first()->id,
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

        $customer->is_star = !$customer->is_star;
        $customer->save();

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
