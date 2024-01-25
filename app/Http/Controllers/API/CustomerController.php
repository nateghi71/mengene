<?php

namespace App\Http\Controllers\API;

use App\Events\CreateCustomerFile;
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

        $customers = $business->customers()->filter()->search()->paginate(10)->withQueryString();

        foreach ($customers as $customer) {
            if ($customer->getRawOriginal('expire_date') > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($customer->getRawOriginal('expire_date')) + 1;
                $customer->daysLeft = $daysLeft;
            }
        }

        return $this->sendResponse([
            'customers' => $customers ? CustomerResource::collection($customers) : [],
            'links' => $customers ? CustomerResource::collection($customers)->response()->getData()->links : [],
            'meta' => $customers ? CustomerResource::collection($customers)->response()->getData()->meta : [],
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
            'number' => 'required|iran_mobile',
            'city_id' => 'required',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'scale' => 'required',
            'area' => 'required|numeric',
            'number_of_rooms' => 'required|numeric',
            'description' => 'required',
            'rahn_amount' => 'exclude_if:type_sale,buy|required',
            'rent_amount' => 'exclude_if:type_sale,buy|required',
            'selling_price' => 'exclude_if:type_sale,rahn|required',
            'access_level' => 'required',
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'floor' => 'exclude_if:type_build,house|required|numeric',
            'floor_number' => 'exclude_if:type_build,house|required|numeric',
            'is_star' => 'nullable',
            'expire_date' => 'required'
        ]);

//        dd($request->all());
        $user = auth()->user();
        $customer = Customer::create([
            'name' => $request->name,
            'number' => $request->number,
            'city_id' => $request->city_id,
            'type_sale' => $request->type_sale,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'type_file' => 'business',
            'scale' => $request->scale,
            'area' => $request->area,
            'number_of_rooms' => $request->number_of_rooms,
            'description' => $request->description,
            'access_level' => $request->access_level,
            'rahn_amount' => $request->type_sale === 'rahn' ? $request->rahn_amount : 0,
            'rent_amount' => $request->type_sale === 'rahn' ? $request->rent_amount : 0,
            'selling_price' => $request->type_sale === 'buy' ? $request->selling_price : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'floor' => $request->type_build === 'apartment' ? $request->floor : 0,
            'floor_number' => $request->type_build === 'apartment' ? $request->floor_number : 0,
            'business_id' => $user->business()->id,
            'user_id' => $user->id,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'expire_date' => $request->expire_date
        ]);

        event(new CreateCustomerFile($customer , $user));

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
            'number' => 'required|iran_mobile',
            'city_id' => 'required',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'scale' => 'required',
            'area' => 'required|numeric',
            'number_of_rooms' => 'required|numeric',
            'description' => 'required',
            'access_level' => 'required',
            'rahn_amount' => 'exclude_if:type_sale,buy|required',
            'rent_amount' => 'exclude_if:type_sale,buy|required',
            'selling_price' => 'exclude_if:type_sale,rahn|required',
            'elevator' => 'sometimes|nullable',
            'parking' => 'sometimes|nullable',
            'store' => 'sometimes|nullable',
            'floor' => 'exclude_if:type_build,house|required|numeric',
            'floor_number' => 'exclude_if:type_build,house|required|numeric',
            'is_star' => 'sometimes|nullable',
            'expire_date' => 'required'
        ]);

//        $user = auth()->user();
        $customer->update([
            'name' => $request->name,
            'number' => $request->number,
            'city_id' => $request->city_id,
            'type_sale' => $request->type_sale,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'scale' => $request->scale,
            'area' => $request->area,
            'number_of_rooms' => $request->number_of_rooms,
            'description' => $request->description,
            'access_level' => $request->access_level,
            'rahn_amount' => $request->type_sale === 'rahn' ? $request->rahn_amount : 0,
            'rent_amount' => $request->type_sale === 'rahn' ? $request->rent_amount : 0,
            'selling_price' => $request->type_sale === 'buy' ? $request->selling_price : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'floor' => $request->type_build === 'apartment' ? $request->floor : 0,
            'floor_number' => $request->type_build === 'apartment' ? $request->floor_number : 0,
//            'business_id' => $user->business()->id,
//            'user_id' => $user->id,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
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
}
