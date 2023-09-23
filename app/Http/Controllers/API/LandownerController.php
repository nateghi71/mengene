<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Http\Resources\LandownerResource;
use App\Models\Business;
use App\Models\Landowner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LandownerController extends BaseController
{
    public function index()
    {
        $user = auth('api')->user();
        $business = $user->business()->get()->pluck('en_name')->pop();
        $businesss = $user->business()->get()->pluck('id')->pop();

        if ($user->business && $user->business->is_accepted) {
            $landowners = Landowner::where('business_en_name', $business)
                ->where('status', 1)
                ->orderBy('is_star', 'desc')
                ->orderBy('expiry_date', 'asc')
                ->get();
            $indexedLandowners = $landowners->groupBy('type');
            $rentLandowners = $indexedLandowners->get('rahn');
            $buyLandowners = $indexedLandowners->get('buy');

            foreach ($landowners as $landowner) {
                if ($landowner->expiry_date > Carbon::now()) {
                    // dd(date(Carbon::now()));
                    $daysLeft = Carbon::now()->diffInDays($landowner->expiry_date) + 1;
                    $landowner->expiry_date = $daysLeft;
                }
            }
//            dd($landowners);

            $ilandowners = Landowner::where('business_en_name', $business)
                ->where('status', 0)
                ->orderBy('is_star', 'desc')
                ->orderBy('expiry_date', 'asc')
                ->get();
            $indexediLandowners = $ilandowners->groupBy('type');
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
        } else {
            return $this->sendError('You are not authorized to access this resource.');
        }
    }


    public function show(Landowner $landowner)
    {
        $this->authorize('view', $landowner);

        return $this->sendResponse(new LandownerResource($landowner), 'Landowner retrieved successfully.');
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

        $landowner = Landowner::create($request->all());

        return $this->sendResponse(new LandownerResource($landowner), 'Landowner created successfully.');
    }

    public function update(Request $request, Landowner $landowner)
    {
        $this->authorize('update', $landowner);

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
            $landowner->update($input);
        } else {
            $landowner->update($request->all());
        }

        return $this->sendResponse(new LandownerResource($landowner), 'Landowner updated successfully.');
    }

    public function destroy(Landowner $landowner)
    {
        $this->authorize('update', $landowner);

        $landowner->delete();

        return $this->sendResponse([], 'Landowner deleted successfully.');
    }

    public function star(Landowner $landowner)
    {
        $this->authorize('update', $landowner);

        $landowner->is_star = !$landowner->is_star;
        $landowner->save();

        return $this->sendResponse(new LandownerResource($landowner), 'Landowner star status updated successfully.');
    }

    public function status(Landowner $landowner)
    {
        $this->authorize('update', $landowner);

        $landowner->status = !$landowner->status;
        $landowner->save();

        return $this->sendResponse(new LandownerResource($landowner), 'Landowner status updated successfully.');
    }

    public function type(Landowner $landowner)
    {
        $this->authorize('update', $landowner);

        if ($landowner->type == 'buy') {
            $landowner->type = 'rahn';
            $landowner->save();
        } else {
            $landowner->type = 'buy';
            $landowner->save();
        }

        return $this->sendResponse(new LandownerResource($landowner), 'Landowner type updated successfully.');
    }
}
