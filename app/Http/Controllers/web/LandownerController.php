<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\Landowner;
use App\Models\Business;
use Carbon\Carbon;
use App\Http\Controllers\API\MyBaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Landowner as LandownerResource;

class LandownerController extends Controller
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
//        $landowners = $user->businessLandowner()->where('status', 1)
//            ->orderBy('is_star', 'desc')->orderBy('expiry_date', 'asc')->get();
//        $ilandowners = $user->businessLandowner()->where('status', 0)
//            ->orderBy('is_star', 'desc')->orderBy('expiry_date', 'asc')->get();
//        $user = new User();
//        $business = $user->business();
//        dd(Business::where('user_id', auth('web')->id())->get());
//        $id = Business::where('user_id', auth('web')->id())->pluck('id');
////        dd($id);
        if ($user->business && $user->business->is_accepted) {
            $landowners = Landowner::where('business_en_name', $business)->where('status', 1)
                ->orderBy('is_star', 'desc')->orderBy('expiry_date', 'asc')->get();

            $indexedLandowners = $landowners->groupBy('type');
            $rentLandowners = $indexedLandowners->get('rahn');
            $buyLandowners = $indexedLandowners->get('buy');
//            dd($buyLandowners);
            foreach ($landowners as $landowner) {
                if ($landowner->expiry_date > Carbon::now()) {
                    // dd(date(Carbon::now()));
                    $daysLeft = Carbon::now()->diffInDays($landowner->expiry_date) + 1;
                    $landowner->expiry_date = $daysLeft;
                }
            }

            $ilandowners = Landowner::where('business_en_name', $business)->where('status', 0)
                ->orderBy('is_star', 'desc')->orderBy('expiry_date', 'asc')->get();
            $indexediLandowners = $ilandowners->groupBy('type');
            $rentiLandowners = $indexediLandowners->get('rahn');
            $buyiLandowners = $indexediLandowners->get('buy');
//            dd($rentiLandowners);

//        return $this->sendResponse(LandownerResource::collection($landowners), 'Landowners retrieved successfully.');
            return view('landowner.landowners', compact('landowners', 'ilandowners', 'rentLandowners', 'buyLandowners', 'rentiLandowners', 'buyiLandowners'));
        } else {
            return view('dashboard', compact('user'));
        }

    }


    public
    function show(Landowner $landowner)
    {

        $this->authorize('view', $landowner);

//        $landowner = Landowner::find($id);

        if (is_null($landowner)) {
            return ('Landowner not found.');
        }
        return view('landowner.landowner', compact('landowner'));
//        return $this->sendResponse(new LandownerResource($landowner), 'Landowner retrieved successfully.');
    }

    public
    function create()
    {
//        dd('hello');
        return view('landowner.create');
    }

    public
    function store(Request $request)
    {
//        $landowner = new Landowner();
//        $input = $request->all();
//        dd(Business::where('user_id', auth('web')->id())->pluck('id')->pop());
        $request['business_en_name'] = Business::where('user_id', auth('web')->id())->pluck('en_name')->pop();
        $request['city'] = auth()->user()->pluck('city')->pop();

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
//        dd($request['status']);

//        if ($validator->fails()) {
//            return 'invalid values';
//        }
//        dd($request['city']);
        $landowner = Landowner::create($request->all());
        return redirect(route('landowners'));

    }

    public
    function edit(Landowner $landowner)
    {
        $this->authorize('update', $landowner);
        return view('landowner.edit', compact('landowner'));
    }

    public
    function update(Request $request, Landowner $landowner)
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
            return redirect(route('landowners'));
        } else {
            $landowner->update($request->all());
            return redirect(route('landowners'));
        }

    }

    public
    function destroy(Landowner $landowner)
    {
        $this->authorize('update', $landowner);

        $landowner->delete();

        return redirect()->back();
    }

    public
    function star(Landowner $landowner)
    {
        $this->authorize('update', $landowner);

        if ($landowner->is_star == 0) {
            $landowner->is_star = 1;
            $landowner->save();
        } else {
            $landowner->is_star = 0;
            $landowner->save();
        }
        return redirect(route('landowner', $landowner));

    }

    public
    function status(Landowner $landowner)
    {
        $this->authorize('update', $landowner);

        if ($landowner->status == 0) {
            $landowner->status = 1;
            $landowner->save();
        } else {
            $landowner->status = 0;
            $landowner->save();
        }
        return redirect()->back();

    }

    public
    function type(Landowner $landowner)
    {
        $this->authorize('update', $landowner);

        if ($landowner->type == 'buy') {
            $landowner->type = 'rahn';
            $landowner->save();
        } else {
            $landowner->type = 'buy';
            $landowner->save();
        }
        return redirect(route('landowner', $landowner));

    }

}
