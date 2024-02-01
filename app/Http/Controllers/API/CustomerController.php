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
use App\Notifications\ReminderForCustomerNotification;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends BaseController
{
    public function index()
    {
        try
        {
            $this->authorize('viewAny' , Customer::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
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
        return $this->sendResponse([
            'user' => $user,
        ], 'user retrieved successfully');
    }

    public function show(Customer $customer)
    {
        try
        {
            $this->authorize('view' , $customer);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        return $this->sendResponse([
            'customer' => new CustomerResource($customer),
        ], 'Customer retrieved successfully');
    }

    public function store(Request $request)
    {
        try
        {
            $this->authorize('create' , Customer::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $validator = Validator::make($request->all() , [
            'type_sale' => 'required',
            'access_level' => 'required',
            'name' => 'required',
            'number' => 'required|iran_mobile',
            'scale' => 'required|numeric',
            'city_id' => 'required|numeric',
            'area' => 'required|numeric',
            'expire_date' => 'required',
            'selling_price' => 'exclude_if:type_sale,rahn|required',
            'rahn_amount' => 'exclude_if:type_sale,buy|required',
            'rent_amount' => 'exclude_if:type_sale,buy|required',
            'type_work' => 'required',
            'type_build' => 'required',
            'document' => 'exclude_if:type_sale,rahn|required',
            'address' => 'required',
            'discharge' => 'nullable',
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'is_star' => 'nullable',
            'exist_owner' => 'nullable',
            //more
            'year_of_construction' => 'nullable',
            'year_of_reconstruction' => 'nullable',
            'number_of_rooms' => 'nullable|numeric',
            'floor_number' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
            'floor' => 'exclude_if:type_build,land|nullable|numeric',
            'floor_covering' => 'nullable',
            'cooling' => 'nullable',
            'heating' => 'nullable',
            'cabinets' => 'nullable',
            'view' => 'nullable',
            'description' => 'nullable',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error', $validator->errors() , 400);
        }

        $user = auth()->user();
        $customer = Customer::create([
            'type_file' => 'business',
            'type_sale' => $request->type_sale,
            'access_level' => $request->access_level,
            'name' => $request->name,
            'number' => $request->number,
            'scale' => $request->scale,
            'city_id' => $request->city_id,
            'area' => $request->area,
            'expire_date' => $request->expire_date,
            'selling_price' => ($request->type_sale === 'buy' && $request->selling_price !== null) ? $request->selling_price : 0,
            'rahn_amount' => ($request->type_sale === 'rahn' && $request->rahn_amount !== null) ? $request->rahn_amount : 0,
            'rent_amount' => ($request->type_sale === 'rahn' && $request->rent_amount !== null) ? $request->rent_amount : 0,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'document' => $request->document,
            'address' => $request->address,
            'discharge' => $request->has('discharge') ? 1 : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'exist_owner' => $request->has('exist_owner') ? 1 : 0,
            //more
            'year_of_construction' => $request->year_of_construction,
            'year_of_reconstruction' => $request->year_of_reconstruction,
            'number_of_rooms' => $request->number_of_rooms,
            'floor_number' => ($request->type_build !== 'house' && $request->type_build !== 'land' && $request->floor_number !== null) ? $request->floor_number : 0,
            'floor' => ($request->type_build !== 'land' && $request->floor !== null) ? $request->floor : 0,
            'floor_covering' => $request->floor_covering,
            'cooling' => $request->cooling,
            'heating' => $request->heating,
            'cabinets' => $request->cabinets,
            'view' => $request->view,
            'description' => $request->description,
            'business_id' => $user->business()->id,
            'user_id' => $user->id,
        ]);

        event(new CreateCustomerFile($customer , $user));

        return $this->sendResponse(['customer' => new CustomerResource($customer)]
            , 'Customer created successfully.');
    }

    public function update(Request $request, Customer $customer)
    {
        try
        {
            $this->authorize('update' , $customer);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $validator = Validator::make($request->all() , [
            'type_sale' => 'required',
            'access_level' => 'required',
            'name' => 'required',
            'number' => 'required|iran_mobile',
            'scale' => 'required|numeric',
            'city_id' => 'required|numeric',
            'area' => 'required|numeric',
            'expire_date' => 'required',
            'selling_price' => 'exclude_if:type_sale,rahn|required',
            'rahn_amount' => 'exclude_if:type_sale,buy|required',
            'rent_amount' => 'exclude_if:type_sale,buy|required',
            'type_work' => 'required',
            'type_build' => 'required',
            'document' => 'exclude_if:type_sale,rahn|required',
            'address' => 'required',
            'discharge' => 'nullable',
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'is_star' => 'nullable',
            'exist_owner' => 'nullable',
            //more
            'year_of_construction' => 'nullable',
            'year_of_reconstruction' => 'nullable',
            'number_of_rooms' => 'nullable|numeric',
            'floor_number' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
            'floor' => 'exclude_if:type_build,land|nullable|numeric',
            'floor_covering' => 'nullable',
            'cooling' => 'nullable',
            'heating' => 'nullable',
            'cabinets' => 'nullable',
            'view' => 'nullable',
            'description' => 'nullable',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error', $validator->errors() , 400);
        }

//        $user = auth()->user();
        $customer->update([
            'type_file' => 'business',
            'type_sale' => $request->type_sale,
            'access_level' => $request->access_level,
            'name' => $request->name,
            'number' => $request->number,
            'scale' => $request->scale,
            'city_id' => $request->city_id,
            'area' => $request->area,
            'expire_date' => $request->expire_date,
            'selling_price' => ($request->type_sale === 'buy' && $request->selling_price !== null) ? $request->selling_price : 0,
            'rahn_amount' => ($request->type_sale === 'rahn' && $request->rahn_amount !== null) ? $request->rahn_amount : 0,
            'rent_amount' => ($request->type_sale === 'rahn' && $request->rent_amount !== null) ? $request->rent_amount : 0,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'document' => $request->document,
            'address' => $request->address,
            'discharge' => $request->has('discharge') ? 1 : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'exist_owner' => $request->has('exist_owner') ? 1 : 0,
            //more
            'year_of_construction' => $request->year_of_construction,
            'year_of_reconstruction' => $request->year_of_reconstruction,
            'number_of_rooms' => $request->number_of_rooms,
            'floor_number' => ($request->type_build !== 'house' && $request->type_build !== 'land' && $request->floor_number !== null) ? $request->floor_number : 0,
            'floor' => ($request->type_build !== 'land' && $request->floor !== null) ? $request->floor : 0,
            'floor_covering' => $request->floor_covering,
            'cooling' => $request->cooling,
            'heating' => $request->heating,
            'cabinets' => $request->cabinets,
            'view' => $request->view,
            'description' => $request->description,
//            'business_id' => $user->business()->id,
//            'user_id' => $user->id,
        ]);

        return $this->sendResponse(['customer' => new CustomerResource($customer)],
            'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        try
        {
            $this->authorize('delete' , $customer);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $customer->delete();
        return $this->sendResponse([], 'Customer deleted successfully.');
    }

    public function star(Customer $customer)
    {
        try
        {
            $this->authorize('star' , Customer::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        if ($customer->getRawOriginal('is_star') == 0) {
            $customer->is_star = 1;
            $customer->save();
        } else {
            $customer->is_star = 0;
            $customer->save();
        }

        return $this->sendResponse(['customer' => new CustomerResource($customer)],
            'Customer star status updated successfully.');
    }

    public function setRemainderTime(Request $request){
        try
        {
            $this->authorize('reminder' , Customer::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $user = auth()->user();
        if($user->isFreeUser() || $user->business()->wallet < 200)
            return $this->sendError('Logic Error', ['message' => 'شما به این امکانات دسترسی ندارید.'] , 401);

        $customer = Customer::find($request->customer_id);
        $date = Verta::parse($request->remainder)->datetime()->format('Y-m-d H:i:s');
        $time = new Carbon($date);
        auth()->user()->notify((new ReminderForCustomerNotification($customer , $date))->delay($time));

        return $this->sendResponse([], 'alert is set.');
    }

}
