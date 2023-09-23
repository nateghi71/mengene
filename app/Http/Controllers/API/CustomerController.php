<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Http\Resources\CustomerResource;
use App\Models\Business;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends BaseController
{
    public function index()
    {
        $user = auth('api')->user();
        $business = $user->business()->get()->pluck('en_name')->pop();
        $businesss = $user->business()->get()->pluck('id')->pop();

        if ($user->business && $user->business->is_accepted) {
            $customers = Customer::where('business_en_name', $business)
                ->where('status', 1)
                ->orderBy('is_star', 'desc')
                ->orderBy('expiry_date', 'asc')
                ->get();
            $indexedCustomers = $customers->groupBy('type');
            $rentCustomers = $indexedCustomers->get('rahn');
            $buyCustomers = $indexedCustomers->get('buy');

            foreach ($customers as $customer) {
                if ($customer->expiry_date > Carbon::now()) {
                    // dd(date(Carbon::now()));
                    $daysLeft = Carbon::now()->diffInDays($customer->expiry_date) + 1;
                    $customer->expiry_date = $daysLeft;
                }
            }

            $icustomers = Customer::where('business_en_name', $business)
                ->where('status', 0)
                ->orderBy('is_star', 'desc')
                ->orderBy('expiry_date', 'asc')
                ->get();
            $indexediCustomers = $icustomers->groupBy('type');
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
        } else {
            return $this->sendError('You are not authorized to access this resource.');
        }
    }

    public function dashboard()
    {
        $user = auth('api')->user();
        return response()->json([$user]);
    }

    public function show(Customer $customer)
    {
        $this->authorize('view', $customer);

        return $this->sendResponse(new CustomerResource($customer), 'Customer retrieved successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'address' => 'required',
            'type' => 'required',
            'rooms' => 'required',
            'size' => 'required',
            'price' => 'required',
            'status' => 'required',
            'expiry_date' => 'required',
        ]);

        $request['business_en_name'] = Business::where('user_id', auth('api')->id())->pluck('en_name')->pop();
        $request['city'] = auth()->user()->pluck('city')->pop();

        $customer = Customer::create($request->all());

        return $this->sendResponse(new CustomerResource($customer), 'Customer created successfully.');
    }

    public function update(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'city' => 'required',
            'address' => 'required',
            'type' => 'required',
            'rooms' => 'required',
            'size' => 'required',
            'price' => 'required',
            'status' => 'required',
            'expiry_date' => 'required',
        ]);

        if ($request->type == 'buy') {
            $input = $request->all();
            $input['rent'] = 0;
            $customer->update($input);
        } else {
            $customer->update($request->all());
        }

        return $this->sendResponse(new CustomerResource($customer), 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('update', $customer);

        $customer->delete();

        return $this->sendResponse([], 'Customer deleted successfully.');
    }

    public function star(Customer $customer)
    {
        $this->authorize('update', $customer);

        $customer->is_star = !$customer->is_star;
        $customer->save();

        return $this->sendResponse(new CustomerResource($customer), 'Customer star status updated successfully.');
    }

    public function status(Customer $customer)
    {
        $this->authorize('update', $customer);

        $customer->status = !$customer->status;
        $customer->save();

        return $this->sendResponse(new CustomerResource($customer), 'Customer status updated successfully.');
    }

    public function type(Customer $customer)
    {
        $this->authorize('update', $customer);

        if ($customer->type == 'buy') {
            $customer->type = 'rent';
            $customer->save();
        } else {
            $customer->type = 'buy';
            $customer->save();
        }

        return $this->sendResponse(new CustomerResource($customer), 'Customer type updated successfully.');
    }
}
