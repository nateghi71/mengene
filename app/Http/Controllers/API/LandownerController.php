<?php

namespace App\Http\Controllers\API;

use App\Events\CreateLandownerFile;
use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\HelperClasses\UpdateStatusFile;
use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\LandownerResource;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Landowner;
use App\Notifications\ReminderForLandowerNotification;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LandownerController extends BaseController
{
    public function index()
    {
        try
        {
            $this->authorize('viewAny' , Landowner::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $user = auth()->user();
        $business = $user->business();
        $landowners = $business->landowners()->filter()->search()->paginate(10)->withQueryString();

        foreach ($landowners as $landowner) {
            if ($landowner->getRawOriginal('expire_date') > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($landowner->getRawOriginal('expire_date')) + 1;
                $landowner->daysLeft = $daysLeft;
            }
        }

        return $this->sendResponse([
            'landowners' => $landowners ? LandownerResource::collection($landowners) : [],
            'links' => $landowners ? LandownerResource::collection($landowners)->response()->getData()->links : [],
            'meta' => $landowners ? LandownerResource::collection($landowners)->response()->getData()->meta : [],
        ], 'Landowners retrieved successfully.');
    }

    public function indexSub()
    {
        try
        {
            $this->authorize('subscription' , Landowner::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $user = auth()->user();
        $city_id = $user->business()->city_id;
        $area = $user->business()->area;

        $files = Landowner::whereNull('business_id')->whereNot('access_level' , 'public')->where('city_id' , $city_id)->where('area' , $area)
            ->where('expire_date' , '>' , Carbon::now())->filter()->paginate(10)->withQueryString();

        foreach ($files as $file) {
            if ($file->getRawOriginal('expire_date') > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($file->getRawOriginal('expire_date')) + 1;
                $file->daysLeft = $daysLeft;
            }
        }

        return $this->sendResponse([
            'files' => $files ? LandownerResource::collection($files) : [],
            'links' => $files ? LandownerResource::collection($files)->response()->getData()->links : [],
            'meta' => $files ? LandownerResource::collection($files)->response()->getData()->meta : [],
        ], 'Files retrieved successfully.');
    }

    public function show(Landowner $landowner)
    {
        try
        {
            $this->authorize('view' , $landowner);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        return $this->sendResponse([
            'landowner' => new LandownerResource($landowner)],
            'Landowner retrieved successfully.');
    }

    public function store(Request $request)
    {
        try
        {
            $this->authorize('create' , Landowner::class);
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
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error', $validator->errors() , 400);
        }

        try{
            DB::beginTransaction();

            $user = auth()->user();
            $landowner = Landowner::create([
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

            if($request->images !== null)
            {
                $imageController = new LandownerImageController();
                $imageController->store($request->images , $landowner);
            }

            event(new CreateLandownerFile($landowner , $user));

            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->sendError('Database Error', $e->getMessage() , 500);
        }

        return $this->sendResponse([
            'landowner' => new LandownerResource($landowner)],
            'Landowner created successfully.');
    }

    public function update(Request $request, Landowner $landowner)
    {
        try
        {
            $this->authorize('update' , $landowner);
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
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error', $validator->errors() , 400);
        }

//        $user = auth()->user();
        $landowner->update([
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

        return $this->sendResponse([
            'landowner' => new LandownerResource($landowner)],
            'Landowner updated successfully.');
    }

    public function destroy(Landowner $landowner)
    {
        try
        {
            $this->authorize('delete' , $landowner);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $landowner->delete();

        return $this->sendResponse([], 'Landowner deleted successfully.');
    }

    public function star(Landowner $landowner)
    {
        try
        {
            $this->authorize('star' , Landowner::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        if ($landowner->getRawOriginal('is_star') == 0) {
            $landowner->is_star = 1;
            $landowner->save();
        } else {
            $landowner->is_star = 0;
            $landowner->save();
        }
        return $this->sendResponse([
            'landowner' => new LandownerResource($landowner)],
            'Landowner star status updated successfully.');
    }

    public function buyFile(Landowner $landowner)
    {
        try
        {
            $this->authorize('subscription' , Landowner::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $user = auth()->user();
        $landowner->update([
            'type_file' => 'business' ,
            'business_id' => $user->business()->id,
            'user_id' => $user->id,
        ]);

        return $this->sendResponse([
            'landowner' => new LandownerResource($landowner)],
            'file buy successfully.');
    }

    public function setRemainderTime(Request $request){
        try
        {
            $this->authorize('reminder' , Landowner::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $user = auth()->user();
        if($user->isFreeUser() || $user->business()->wallet < 200)
            return $this->sendError('Logic Error', ['message' => 'شما به این امکانات دسترسی ندارید.'] , 401);

        $landowner = Landowner::find($request->landowner_id);
        $date = Verta::parse($request->remainder)->datetime()->format('Y-m-d H:i:s');
        $time = new Carbon($date);
        auth()->user()->notify((new ReminderForLandowerNotification($landowner , $date))->delay($time));

        return $this->sendResponse([], 'alert is set.');
    }

}
