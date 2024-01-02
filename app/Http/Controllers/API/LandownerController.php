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
            return response()->json(['message' => 'you dont have a business']);
        }

        $user = auth()->user();
        $business = $user->business();

        $landowners = $business->landowners()->where('status', 'active')
            ->orderBy('is_star', 'desc')->orderBy('expire_date', 'asc')->get();
        $ilandowners = $business->landowners()->where('status', 'unknown')
            ->orderBy('is_star', 'desc')->orderBy('expire_date', 'asc')->get();

        $indexedLandowners = $landowners->groupBy('type_sale');
        $rentLandowners = $indexedLandowners->get('rahn');
        $buyLandowners = $indexedLandowners->get('buy');
        foreach ($landowners as $landowner) {
            if ($landowner->expire_date > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($landowner->expire_date) + 1;
                $landowner->daysLeft = $daysLeft;
            }
        }

        $indexediLandowners = $ilandowners->groupBy('type_sale');
        $rentiLandowners = $indexediLandowners->get('rahn');
        $buyiLandowners = $indexediLandowners->get('buy');

        return $this->sendResponse([
            'landowners' => LandownerResource::collection($landowners),
            'ilandowners' => LandownerResource::collection($ilandowners),
            'rentLandowners' => $rentLandowners ? LandownerResource::collection($rentLandowners) : [],
            'rentiLandowners' => $rentiLandowners ? LandownerResource::collection($rentiLandowners) : [],
            'buyLandowners' => $buyLandowners ? LandownerResource::collection($buyLandowners) : [],
            'buyiLandowners' => $buyiLandowners ? LandownerResource::collection($buyiLandowners) : [],
        ], 'Landowners retrieved successfully.');
    }


    public function show(Landowner $landowner)
    {
        try
        {
            $this->authorize('view' , $landowner);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'you dont have a business']);
        }

        return $this->sendResponse(new LandownerResource($landowner), 'Landowner retrieved successfully.');
    }

    public function store(Request $request)
    {
        try
        {
            $this->authorize('create' , Landowner::class);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'you dont have a business']);
        }

        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'city' => 'required',
            'status' => 'required',
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
        $landowner = Landowner::create([
            'name' => $request->name,
            'number' => $request->number,
            'city' => $request->city,
            'status' => $request->status,
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
            'business_id' => $user->business()->id,
            'user_id' => $user->id,
            'is_star' => $request->is_star,
            'expire_date' => $request->expire_date
        ]);

        return $this->sendResponse(new LandownerResource($landowner), 'Landowner created successfully.');
    }

    public function update(Request $request, Landowner $landowner)
    {
        try
        {
            $this->authorize('update' , $landowner);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'you dont have a business']);
        }

        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'city' => 'required',
            'status' => 'required',
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

        $landowner->update([
            'name' => $request->name,
            'number' => $request->number,
            'city' => $request->city,
            'status' => $request->status,
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
//            'business_id' => $user->business()->id,
//            'user_id' => $user->id,
            'is_star' => $request->is_star,
            'expire_date' => $request->expire_date

        ]);

        return $this->sendResponse(new LandownerResource($landowner), 'Landowner updated successfully.');
    }

    public function destroy(Landowner $landowner)
    {
        try
        {
            $this->authorize('delete' , $landowner);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'you dont have a business']);
        }

        $landowner->delete();

        return $this->sendResponse([], 'Landowner deleted successfully.');
    }

    public function star(Landowner $landowner)
    {
        try
        {
            $this->authorize('update' , $landowner);
        }
        catch (AuthorizationException $exception)
        {
            return response()->json(['message' => 'you dont have a business']);
        }

        $landowner->is_star = !$landowner->is_star;
        $landowner->save();

        return $this->sendResponse(new LandownerResource($landowner), 'Landowner star status updated successfully.');
    }

}
