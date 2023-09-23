<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Business;
use Carbon\Carbon;
use App\Http\Controllers\API\MyBaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Customer as CustomerResource;

class CustomerController extends Controller
{
    public function index()
    {
        $user = auth('web')->user();
        $business = $user->business()->get()->pluck('en_name')->pop();
        $businesss = $user->business()->get()->pluck('id')->pop();
//        dd($business);
//* forbusines       $bis = Business::where('en_name', $business)->get();
//        foreach ($bis as $bi) {
//            $users = User::where('id', $bi->user_id)->get();
//            dump($users);
//            dump($bi->user_id);
//        }
// *       dd($bis);
//        false gereftan tamam user ha


//        dd($business);
//        $customers = $user->businessCustomer()->where('status', 1)
//            ->orderBy('is_star', 'desc')->orderBy('expiry_date', 'asc')->get();
//        $icustomers = $user->businessCustomer()->where('status', 0)
//            ->orderBy('is_star', 'desc')->orderBy('expiry_date', 'asc')->get();
//        $user = new User();
//        $business = $user->business();
//        dd(Business::where('user_id', auth('web')->id())->get());
//        $id = Business::where('user_id', auth('web')->id())->pluck('id');
////        dd($id);
        if ($user->business && $user->business->is_accepted) {
            $customers = Customer::where('business_en_name', $business)->where('status', 1)
                ->orderBy('is_star', 'desc')->orderBy('expiry_date', 'asc')->get();

            $indexedCustomers = $customers->groupBy('type');
            $rentCustomers = $indexedCustomers->get('rahn');
            $buyCustomers = $indexedCustomers->get('buy');
//            dd($buyCustomers);
            foreach ($customers as $customer) {
                if ($customer->expiry_date > Carbon::now()) {
                    // dd(date(Carbon::now()));
                    $daysLeft = Carbon::now()->diffInDays($customer->expiry_date) + 1;
                    $customer->expiry_date = $daysLeft;
                }
            }

            $icustomers = Customer::where('business_en_name', $business)->where('status', 0)
                ->orderBy('is_star', 'desc')->orderBy('expiry_date', 'asc')->get();
            $indexediCustomers = $icustomers->groupBy('type');
            $rentiCustomers = $indexediCustomers->get('rahn');
            $buyiCustomers = $indexediCustomers->get('buy');
//            dd($rentiCustomers);

//        return $this->sendResponse(CustomerResource::collection($customers), 'Customers retrieved successfully.');
            return view('customer.customers', compact('customers', 'icustomers', 'rentCustomers', 'buyCustomers', 'rentiCustomers', 'buyiCustomers'));
        } else {
            return view('dashboard', compact('user'));
        }

    }

    public function dashboard()
    {
        $user = auth('web')->user();
        return view('dashboard', compact('user'));
    }

    public
    function show(Customer $customer)
    {

        $this->authorize('view', $customer);

//        $customer = Customer::find($id);

        if (is_null($customer)) {
            return ('Customer not found.');
        }
        return view('customer.customer', compact('customer'));
//        return $this->sendResponse(new CustomerResource($customer), 'Customer retrieved successfully.');
    }

    public
    function create()
    {
//        dd('hello');
        return view('customer.create');
    }

    public
    function store(Request $request)
    {
//        $customer = new Customer();
//        $input = $request->all();
//        dd(Business::where('user_id', auth('web')->id())->pluck('id')->pop());
        $request['business_en_name'] = Business::where('user_id', auth('web')->id())->pluck('en_name')->pop();
        $request['city'] = auth()->user()->pluck('city')->pop();

        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'address' => 'required',
            'type' => 'required',
            'price' => 'required',
            'rooms' => 'required',
            'size' => 'required',
            'status' => 'required',
            'expiry_date' => 'required',
        ]);
//        dd($request['status']);

//        if ($validator->fails()) {
//            return 'invalid values';
//        }
//        dd($request['city']);
        $customer = Customer::create($request->all());
        return redirect(route('customers'));

    }

    public
    function edit(Customer $customer)
    {
        $this->authorize('update', $customer);
        return view('customer.edit', compact('customer'));
    }

    public
    function update(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);
        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'city' => 'required',
            'address' => 'required',
            'type' => 'required',
            'price' => 'required',
            'rooms' => 'required',
            'size' => 'required',
            'status' => 'required',
            'expiry_date' => 'required',
        ]);
        if ($request->type == 'buy') {
            $input = $request->all();
            $input['rent'] = 0;
            $customer->update($input);
            return redirect(route('customers'));
        } else {
            $customer->update($request->all());
            return redirect(route('customers'));
        }

    }

    public
    function destroy(Customer $customer)
    {
        $this->authorize('update', $customer);

        $customer->delete();

        return redirect()->back();
    }

    public
    function star(Customer $customer)
    {
        $this->authorize('update', $customer);

        if ($customer->is_star == 0) {
            $customer->is_star = 1;
            $customer->save();
        } else {
            $customer->is_star = 0;
            $customer->save();
        }
        return redirect(route('customer', $customer));

    }

    public
    function status(Customer $customer)
    {
        $this->authorize('update', $customer);

        if ($customer->status == 0) {
            $customer->status = 1;
            $customer->save();
        } else {
            $customer->status = 0;
            $customer->save();
        }
        return redirect()->back();

    }

    public
    function type(Customer $customer)
    {
        $this->authorize('update', $customer);

        if ($customer->type == 'buy') {
            $customer->type = 'rent';
            $customer->save();
        } else {
            $customer->type = 'buy';
            $customer->save();
        }
        return redirect(route('customer', $customer));

    }

}
