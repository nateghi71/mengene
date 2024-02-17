<?php

namespace App\Http\Controllers\API;

use App\Events\CreateCustomerFile;
use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\HelperClasses\UpdateStatusFile;
use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Http\Requests\CustomerRequest;
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

    public function store(CustomerRequest $request)
    {
        try
        {
            $this->authorize('create' , Customer::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

//        $validator = Validator::make($request->all() , [
//            'type_sale' => 'required',
//            'access_level' => 'required',
//            'name' => 'required',
//            'number' => 'required|iran_mobile',
//            'scale' => 'required|numeric',
//            'city_id' => 'required|numeric',
//            'area' => 'required|numeric',
//            'expire_date' => 'required',
//            'selling_price' => 'exclude_if:type_sale,rahn|required|numeric',
//            'rahn_amount' => 'exclude_if:type_sale,buy|required|numeric',
//            'rent_amount' => 'exclude_if:type_sale,buy|required|numeric',
//            'type_work' => 'required',
//            'type_build' => 'required',
//            'document' => 'exclude_if:type_sale,rahn|required',
//            'address' => 'required',
//            //more
//            'year_of_construction' => 'exclude_if:type_build,land|nullable|numeric',
//            'year_of_reconstruction' => 'exclude_if:type_build,land|nullable|numeric',
//            'number_of_rooms' => 'exclude_if:type_build,land|nullable|numeric',
//            'floor_number' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
//            'floor' => 'exclude_if:type_build,land|nullable|numeric',
//            'floor_covering' => 'exclude_if:type_build,land|nullable',
//            'cooling' => 'exclude_if:type_build,land|nullable',
//            'heating' => 'exclude_if:type_build,land|nullable',
//            'cabinets' => 'exclude_if:type_build,land|nullable',
//            'view' => 'exclude_if:type_build,land|nullable',
//            'number_of_unit_in_floor' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
//            'number_unit' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
//            'postal_code' => 'exclude_if:type_build,land|nullable|numeric',
//            'plaque' => 'exclude_if:type_build,land|nullable|numeric',
//            'state_of_electricity' => 'exclude_if:type_build,land|nullable',
//            'state_of_water' => 'exclude_if:type_build,land|nullable',
//            'state_of_gas' => 'exclude_if:type_build,land|nullable',
//            'state_of_phone' => 'exclude_if:type_build,land|nullable',
//            'Direction_of_building' => 'exclude_if:type_build,land|nullable',
//            'water_heater' => 'exclude_if:type_build,land|nullable',
//            'description' => 'nullable',
//
//            'discharge' => 'exclude_if:type_build,land|nullable',
//            'elevator' => 'exclude_if:type_build,land|nullable',
//            'parking' => 'exclude_if:type_build,land|nullable',
//            'store' => 'exclude_if:type_build,land|nullable',
//            'is_star' => 'exclude_if:type_build,land|nullable',
//            'exist_owner' => 'exclude_if:type_build,land|nullable',
//            'terrace' => 'exclude_if:type_build,land|nullable',
//            'air_conditioning_system' => 'exclude_if:type_build,land|nullable',
//            'yard' => 'exclude_if:type_build,land|nullable',
//            'pool' => 'exclude_if:type_build,land|nullable',
//            'sauna' => 'exclude_if:type_build,land|nullable',
//            'Jacuzzi' => 'exclude_if:type_build,land|nullable',
//            'video_iphone' => 'exclude_if:type_build,land|nullable',
//            'Underground' => 'exclude_if:type_build,land|nullable',
//            'Wall_closet' => 'exclude_if:type_build,land|nullable',
//        ]);
//
//        if($validator->fails())
//        {
//            return $this->sendError('Validation Error', $validator->errors() , 400);
//        }

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
            //more
            'year_of_construction' => ($request->type_build !== 'land' && $request->year_of_construction !== null) ? $request->year_of_construction : null,
            'year_of_reconstruction' => ($request->type_build !== 'land' && $request->year_of_reconstruction !== null) ? $request->year_of_reconstruction : null,
            'number_of_rooms' => ($request->type_build !== 'land' && $request->number_of_rooms !== null) ? $request->number_of_rooms : null,
            'floor_number' => ($request->type_build !== 'land' && $request->floor_number !== null) ? $request->floor_number : null,
            'floor' => ($request->type_build !== 'house' && $request->type_build !== 'land' && $request->floor !== null) ? $request->floor : null,
            'floor_covering' => ($request->type_build !== 'land' && $request->floor_covering !== null) ? $request->floor_covering : 'null',
            'cooling' => ($request->type_build !== 'land' && $request->cooling !== null) ? $request->cooling : 'null',
            'heating' => ($request->type_build !== 'land' && $request->heating !== null) ? $request->heating : 'null',
            'cabinets' => ($request->type_build !== 'land' && $request->cabinets !== null) ? $request->cabinets : 'null',
            'view' => ($request->type_build !== 'land' && $request->view !== null) ? $request->view : 'null',
            'number_of_unit_in_floor' => ($request->type_build !== 'house' && $request->type_build !== 'land' && $request->number_of_unit_in_floor !== null) ? $request->number_of_unit_in_floor : null,
            'number_unit' => ($request->type_build !== 'house' && $request->type_build !== 'land' && $request->number_unit !== null) ? $request->number_unit : null,
            'postal_code' => ($request->type_build !== 'land' && $request->postal_code !== null) ? $request->postal_code : null,
            'plaque' => ($request->type_build !== 'land' && $request->plaque !== null) ? $request->plaque : null,
            'state_of_electricity' => ($request->type_build !== 'land' && $request->state_of_electricity !== null) ? $request->state_of_electricity : 'null',
            'state_of_water' => ($request->type_build !== 'land' && $request->state_of_water !== null) ? $request->state_of_water : 'null',
            'state_of_gas' => ($request->type_build !== 'land' && $request->state_of_gas !== null) ? $request->state_of_gas : 'null',
            'state_of_phone' => ($request->type_build !== 'land' && $request->state_of_phone !== null) ? $request->state_of_phone : 'null',
            'Direction_of_building' => ($request->type_build !== 'land' && $request->Direction_of_building !== null) ? $request->Direction_of_building : 'null',
            'water_heater' => ($request->type_build !== 'land' && $request->water_heater !== null) ? $request->water_heater : 'null',
            'description' => $request->description,
            'business_id' => $user->business()->id,
            'user_id' => $user->id,

            'discharge' => $request->has('discharge') ? 1 : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'exist_owner' => $request->has('exist_owner') ? 1 : 0,
            'terrace' => $request->has('terrace') ? 1 : 0,
            'air_conditioning_system' => $request->has('air_conditioning_system') ? 1 : 0,
            'yard' => $request->has('yard') ? 1 : 0,
            'pool' => $request->has('pool') ? 1 : 0,
            'sauna' => $request->has('sauna') ? 1 : 0,
            'Jacuzzi' => $request->has('Jacuzzi') ? 1 : 0,
            'video_iphone' => $request->has('video_iphone') ? 1 : 0 ,
            'Underground' => $request->has('Underground') ? 1 : 0,
            'Wall_closet' => $request->has('Wall_closet') ? 1 : 0,
        ]);

        event(new CreateCustomerFile($customer , $user));

        return $this->sendResponse(['customer' => new CustomerResource($customer)]
            , 'Customer created successfully.');
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        try
        {
            $this->authorize('update' , $customer);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

//        $validator = Validator::make($request->all() , [
//            'type_sale' => 'required',
//            'access_level' => 'required',
//            'name' => 'required',
//            'number' => 'required|iran_mobile',
//            'scale' => 'required|numeric',
//            'city_id' => 'required|numeric',
//            'area' => 'required|numeric',
//            'expire_date' => 'required',
//            'selling_price' => 'exclude_if:type_sale,rahn|required|numeric',
//            'rahn_amount' => 'exclude_if:type_sale,buy|required|numeric',
//            'rent_amount' => 'exclude_if:type_sale,buy|required|numeric',
//            'type_work' => 'required',
//            'type_build' => 'required',
//            'document' => 'exclude_if:type_sale,rahn|required',
//            'address' => 'required',
//            //more
//            'year_of_construction' => 'exclude_if:type_build,land|nullable|numeric',
//            'year_of_reconstruction' => 'exclude_if:type_build,land|nullable|numeric',
//            'number_of_rooms' => 'exclude_if:type_build,land|nullable|numeric',
//            'floor_number' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
//            'floor' => 'exclude_if:type_build,land|nullable|numeric',
//            'floor_covering' => 'exclude_if:type_build,land|nullable',
//            'cooling' => 'exclude_if:type_build,land|nullable',
//            'heating' => 'exclude_if:type_build,land|nullable',
//            'cabinets' => 'exclude_if:type_build,land|nullable',
//            'view' => 'exclude_if:type_build,land|nullable',
//            'number_of_unit_in_floor' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
//            'number_unit' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
//            'postal_code' => 'exclude_if:type_build,land|nullable|numeric',
//            'plaque' => 'exclude_if:type_build,land|nullable|numeric',
//            'state_of_electricity' => 'exclude_if:type_build,land|nullable',
//            'state_of_water' => 'exclude_if:type_build,land|nullable',
//            'state_of_gas' => 'exclude_if:type_build,land|nullable',
//            'state_of_phone' => 'exclude_if:type_build,land|nullable',
//            'Direction_of_building' => 'exclude_if:type_build,land|nullable',
//            'water_heater' => 'exclude_if:type_build,land|nullable',
//            'description' => 'nullable',
//
//            'discharge' => 'exclude_if:type_build,land|nullable',
//            'elevator' => 'exclude_if:type_build,land|nullable',
//            'parking' => 'exclude_if:type_build,land|nullable',
//            'store' => 'exclude_if:type_build,land|nullable',
//            'is_star' => 'exclude_if:type_build,land|nullable',
//            'exist_owner' => 'exclude_if:type_build,land|nullable',
//            'terrace' => 'exclude_if:type_build,land|nullable',
//            'air_conditioning_system' => 'exclude_if:type_build,land|nullable',
//            'yard' => 'exclude_if:type_build,land|nullable',
//            'pool' => 'exclude_if:type_build,land|nullable',
//            'sauna' => 'exclude_if:type_build,land|nullable',
//            'Jacuzzi' => 'exclude_if:type_build,land|nullable',
//            'video_iphone' => 'exclude_if:type_build,land|nullable',
//            'Underground' => 'exclude_if:type_build,land|nullable',
//            'Wall_closet' => 'exclude_if:type_build,land|nullable',
//        ]);
//
//        if($validator->fails())
//        {
//            return $this->sendError('Validation Error', $validator->errors() , 400);
//        }

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
            //more
            'year_of_construction' => ($request->type_build !== 'land' && $request->year_of_construction !== null) ? $request->year_of_construction : null,
            'year_of_reconstruction' => ($request->type_build !== 'land' && $request->year_of_reconstruction !== null) ? $request->year_of_reconstruction : null,
            'number_of_rooms' => ($request->type_build !== 'land' && $request->number_of_rooms !== null) ? $request->number_of_rooms : null,
            'floor_number' => ($request->type_build !== 'land' && $request->floor_number !== null) ? $request->floor_number : null,
            'floor' => ($request->type_build !== 'house' && $request->type_build !== 'land' && $request->floor !== null) ? $request->floor : null,
            'floor_covering' => ($request->type_build !== 'land' && $request->floor_covering !== null) ? $request->floor_covering : 'null',
            'cooling' => ($request->type_build !== 'land' && $request->cooling !== null) ? $request->cooling : 'null',
            'heating' => ($request->type_build !== 'land' && $request->heating !== null) ? $request->heating : 'null',
            'cabinets' => ($request->type_build !== 'land' && $request->cabinets !== null) ? $request->cabinets : 'null',
            'view' => ($request->type_build !== 'land' && $request->view !== null) ? $request->view : 'null',
            'number_of_unit_in_floor' => ($request->type_build !== 'house' && $request->type_build !== 'land' && $request->number_of_unit_in_floor !== null) ? $request->number_of_unit_in_floor : null,
            'number_unit' => ($request->type_build !== 'house' && $request->type_build !== 'land' && $request->number_unit !== null) ? $request->number_unit : null,
            'postal_code' => ($request->type_build !== 'land' && $request->postal_code !== null) ? $request->postal_code : null,
            'plaque' => ($request->type_build !== 'land' && $request->plaque !== null) ? $request->plaque : null,
            'state_of_electricity' => ($request->type_build !== 'land' && $request->state_of_electricity !== null) ? $request->state_of_electricity : 'null',
            'state_of_water' => ($request->type_build !== 'land' && $request->state_of_water !== null) ? $request->state_of_water : 'null',
            'state_of_gas' => ($request->type_build !== 'land' && $request->state_of_gas !== null) ? $request->state_of_gas : 'null',
            'state_of_phone' => ($request->type_build !== 'land' && $request->state_of_phone !== null) ? $request->state_of_phone : 'null',
            'Direction_of_building' => ($request->type_build !== 'land' && $request->Direction_of_building !== null) ? $request->Direction_of_building : 'null',
            'water_heater' => ($request->type_build !== 'land' && $request->water_heater !== null) ? $request->water_heater : 'null',
            'description' => $request->description,
//            'business_id' => $user->business()->id,
//            'user_id' => $user->id,

            'discharge' => $request->has('discharge') ? 1 : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'exist_owner' => $request->has('exist_owner') ? 1 : 0,
            'terrace' => $request->has('terrace') ? 1 : 0,
            'air_conditioning_system' => $request->has('air_conditioning_system') ? 1 : 0,
            'yard' => $request->has('yard') ? 1 : 0,
            'pool' => $request->has('pool') ? 1 : 0,
            'sauna' => $request->has('sauna') ? 1 : 0,
            'Jacuzzi' => $request->has('Jacuzzi') ? 1 : 0,
            'video_iphone' => $request->has('video_iphone') ? 1 : 0 ,
            'Underground' => $request->has('Underground') ? 1 : 0,
            'Wall_closet' => $request->has('Wall_closet') ? 1 : 0,
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
