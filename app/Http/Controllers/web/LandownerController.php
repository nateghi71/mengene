<?php

namespace App\Http\Controllers\web;

use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\HelperClasses\UpdateStatusFile;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\Landowner;
use App\Models\Business;
use Carbon\Carbon;
use App\Http\Controllers\API\MyBaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LandownerController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny' , Landowner::class);

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

        return view('landowner.index', compact('landowners', 'ilandowners', 'rentLandowners', 'buyLandowners', 'rentiLandowners', 'buyiLandowners'));
    }

    public function show(Landowner $landowner)
    {
        $this->authorize('view', $landowner);
        return view('landowner.show', compact('landowner'));
    }

    public function create()
    {
        $this->authorize('create', Landowner::class);
        return view('landowner.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Landowner::class);
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
            'business_id' => $user->business()->first()->id,
            'user_id' => $user->id,
            'is_star' => $request->is_star,
            'expire_date' => $request->expire_date
        ]);
        return redirect()->route('landowner.index');

    }

    public function edit(Landowner $landowner)
    {
        $this->authorize('update', $landowner);
        return view('landowner.edit', compact('landowner'));
    }

    public function update(Request $request, Landowner $landowner)
    {
        $this->authorize('update', $landowner);
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
//            'business_id' => $user->business()->first()->id,
//            'user_id' => $user->id,
            'is_star' => $request->is_star,
            'expire_date' => $request->expire_date

        ]);

        return redirect()->route('landowner.index');
    }

    public function destroy(Landowner $landowner)
    {
        $this->authorize('delete', $landowner);

        $landowner->delete();

        return redirect()->back();
    }

    public function star(Landowner $landowner)
    {
        $this->authorize('update', $landowner);

        if ($landowner->is_star == 0) {
            $landowner->is_star = 1;
            $landowner->save();
        } else {
            $landowner->is_star = 0;
            $landowner->save();
        }
        return redirect()->back();

    }
}
