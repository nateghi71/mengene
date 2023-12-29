<?php

namespace App\Http\Controllers\web;

use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\HelperClasses\UpdateStatusFile;
use App\Http\Controllers\Controller;
use App\Models\Landowner;
use App\Models\RandomLink;
use App\Models\User;
use http\Url;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Business;
use Carbon\Carbon;
use App\Http\Controllers\API\MyBaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Customer as CustomerResource;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny' , Customer::class);
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
        return view('customer.index', compact('customers', 'icustomers', 'rentCustomers', 'buyCustomers', 'rentiCustomers', 'buyiCustomers'));
    }

    public function show(Customer $customer)
    {
        $this->authorize('view' , $customer);
        return view('customer.show', compact('customer'));
    }

    public function create()
    {
        $this->authorize('create' , Customer::class);
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create' , Customer::class);
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
        return redirect()->route('customer.index');
    }

    public function edit(Customer $customer)
    {
        $this->authorize('update', $customer);
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);

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

        $user = auth()->user();
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
            'business_id' => $user->business()->first()->id,
            'user_id' => $user->id,
            'is_star' => $request->is_star,
            'expire_date' => $request->expire_date
        ]);
        return redirect()->route('customer.index');
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();

        return redirect()->back();
    }

    public function star(Customer $customer)
    {
        $this->authorize('update', $customer);

        if ($customer->is_star == 0) {
            $customer->is_star = 1;
            $customer->save();
        } else {
            $customer->is_star = 0;
            $customer->save();
        }
        return redirect()->back();
    }

}
