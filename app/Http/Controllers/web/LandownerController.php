<?php

namespace App\Http\Controllers\web;

use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\HelperClasses\UpdateStatusFile;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\Landowner;
use App\Models\Business;
use Carbon\Carbon;
use App\Http\Controllers\API\MyBaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LandownerController extends Controller
{
    public function index($status)
    {
        if ($status == 'active' || $status == 'unknown' || $status == 'deActive')
        {
            $this->authorize('viewAny' , Landowner::class);
            $user = auth()->user();

            $business = $user->business();

            $buyLandowners = $business->landowners()->where('status', $status)->where('type_sale' , 'buy')
                ->orderBy('is_star', 'desc')->orderBy('expire_date', 'asc')->paginate(
                    $perPage = 5, $columns = ['*'], $pageName = 'buy'
                )->fragment('buy')->withQueryString();

            foreach ($buyLandowners as $landowner) {
                if ($landowner->expire_date > Carbon::now()) {
                    $daysLeft = Carbon::now()->diffInDays($landowner->expire_date) + 1;
                    $landowner->daysLeft = $daysLeft;
                }
            }

            $rahnLandowners = $business->landowners()->where('status', $status)->where('type_sale' , 'rahn')
                ->orderBy('is_star', 'desc')->orderBy('expire_date', 'asc')->paginate(
                    $perPage = 5, $columns = ['*'], $pageName = 'rahn'
                )->fragment('rahn')->withQueryString();

            foreach ($rahnLandowners as $landowner) {
                if ($landowner->expire_date > Carbon::now()) {
                    $daysLeft = Carbon::now()->diffInDays($landowner->expire_date) + 1;
                    $landowner->daysLeft = $daysLeft;
                }
            }
            return view('landowner.index', compact('buyLandowners' , 'rahnLandowners'));
        }

        abort(404);
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
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'scale' => 'required',
            'number_of_rooms' => 'required',
            'description' => 'required',
            'rahn_amount' => Rule::requiredIf($request->type_sale == 'rahn'),
            'rent_amount' => Rule::requiredIf($request->type_sale == 'rahn'),
            'selling_price' => Rule::requiredIf($request->type_sale == 'buy'),
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'floor_number' => 'required',
            'is_star' => 'nullable',
            'expire_date' => 'required'
        ]);

        $user = auth()->user();
        $landowner = Landowner::create([
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
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'floor' => $request->floor,
            'floor_number' => $request->floor_number,
            'business_id' => $user->business()->id,
            'user_id' => $user->id,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'expire_date' => Verta::parse($request->expire_date)->datetime()->format('Y-m-d')
        ]);
        return redirect()->route('landowner.index',['status' => 'active']);
    }

    public function edit(Landowner $landowner)
    {
        $landowner->expire_date = verta($landowner->expire_date)->format('Y-m-d');
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
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'scale' => 'required',
            'number_of_rooms' => 'required',
            'description' => 'required',
            'rahn_amount' => Rule::requiredIf($request->type_sale == 'rahn'),
            'rent_amount' => Rule::requiredIf($request->type_sale == 'rahn'),
            'selling_price' => Rule::requiredIf($request->type_sale == 'buy'),
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'floor_number' => 'required',
            'is_star' => 'nullable',
            'expire_date' => 'required'
        ]);

//        $user = auth()->user();
        $landowner->update([
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
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'floor' => $request->floor,
            'floor_number' => $request->floor_number,
//            'business_id' => $user->business()->id,
//            'user_id' => $user->id,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'expire_date' => Verta::parse($request->expire_date)->datetime()->format('Y-m-d')
        ]);

        return redirect()->route('landowner.index',['status' => 'active']);
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
