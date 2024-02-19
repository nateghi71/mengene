<?php

namespace App\Http\Controllers\API;

use App\Events\CreateCustomerFile;
use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\HelperClasses\UpdateStatusFile;
use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Http\Controllers\Controller;
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

class CustomerController extends Controller
{
    use MyBaseController;

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
            'selling_price' => $request->selling_price,
            'rahn_amount' => $request->rahn_amount,
            'rent_amount' => $request->rent_amount,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'document' => $request->document,
            'address' => $request->address,
            //more
            'year_of_construction' => $request->year_of_construction,
            'year_of_reconstruction' => $request->year_of_reconstruction,
            'number_of_rooms' => $request->number_of_rooms,
            'floor_number' => $request->floor_number,
            'floor' => $request->floor,
            'floor_covering' => $request->floor_covering,
            'cooling' => $request->cooling,
            'heating' => $request->heating,
            'cabinets' => $request->cabinets,
            'view' => $request->view,
            'number_of_unit_in_floor' => $request->number_of_unit_in_floor,
            'number_unit' => $request->number_unit,
            'postal_code' => $request->postal_code,
            'plaque' => $request->plaque,
            'state_of_electricity' => $request->state_of_electricity,
            'state_of_water' => $request->state_of_water,
            'state_of_gas' => $request->state_of_gas,
            'state_of_phone' => $request->state_of_phone,
            'Direction_of_building' => $request->Direction_of_building,
            'water_heater' => $request->water_heater,
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
            'selling_price' => $request->selling_price,
            'rahn_amount' => $request->rahn_amount,
            'rent_amount' => $request->rent_amount,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'document' => $request->document,
            'address' => $request->address,
            //more
            'year_of_construction' => $request->year_of_construction,
            'year_of_reconstruction' => $request->year_of_reconstruction,
            'number_of_rooms' => $request->number_of_rooms,
            'floor_number' => $request->floor_number,
            'floor' => $request->floor,
            'floor_covering' => $request->floor_covering,
            'cooling' => $request->cooling,
            'heating' => $request->heating,
            'cabinets' => $request->cabinets,
            'view' => $request->view,
            'number_of_unit_in_floor' => $request->number_of_unit_in_floor,
            'number_unit' => $request->number_unit,
            'postal_code' => $request->postal_code,
            'plaque' => $request->plaque,
            'state_of_electricity' => $request->state_of_electricity,
            'state_of_water' => $request->state_of_water,
            'state_of_gas' => $request->state_of_gas,
            'state_of_phone' => $request->state_of_phone,
            'Direction_of_building' => $request->Direction_of_building,
            'water_heater' => $request->water_heater,
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
