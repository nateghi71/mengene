<?php

namespace App\Http\Controllers\web;

use App\Events\CreateLandownerFile;
use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\User;
use App\Notifications\ReminderForLandowerNotification;
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
    public function index()
    {
        $this->authorize('viewAny' , Landowner::class);
        $user = auth()->user();

        $business = $user->business();

        $landowners = $business->landowners()->filter()->search()->paginate(10)->withQueryString();

        foreach ($landowners as $landowner) {
            if ($landowner->getRawOriginal('expire_date') > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($landowner->getRawOriginal('expire_date')) + 1;
                $landowner->daysLeft = $daysLeft;
            }
        }
        return view('landowner.index', compact('landowners' ));
    }

    public function show(Landowner $landowner)
    {
        $this->authorize('view', $landowner);
        return view('landowner.show', compact('landowner'));
    }

    public function create()
    {
        $provinces = Province::all();
        $this->authorize('create', Landowner::class);
        return view('landowner.create' , compact('provinces'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Landowner::class);
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
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'floor' => 'exclude_if:type_build,house|required|numeric',
            'floor_number' => 'exclude_if:type_build,house|required|numeric',
            'is_star' => 'nullable',
            'expire_date' => 'required'
        ]);

        $user = auth()->user();
        $landowner = Landowner::create([
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
            'rahn_amount' => $request->filled('rahn_amount') ? $request->rahn_amount : 0,
            'rent_amount' => $request->filled('rent_amount') ? $request->rent_amount : 0,
            'selling_price' => $request->filled('selling_price') ? $request->selling_price : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'floor' => $request->filled('floor') ? $request->floor : 0,
            'floor_number' => $$request->filled('floor_number') ? $request->floor_number : 0,
            'business_id' => $user->business()->id,
            'user_id' => $user->id,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'expire_date' => $request->expire_date
        ]);

        event(new CreateLandownerFile($landowner , $user));

        return redirect()->route('landowner.index',['status' => 'active'])->with('message' , 'فایل موردنظر ایجاد شد.');
    }

    public function edit(Landowner $landowner)
    {
        $provinces = Province::all();
        $this->authorize('update', $landowner);
        return view('landowner.edit', compact('landowner' , 'provinces'));
    }

    public function update(Request $request, Landowner $landowner)
    {
        $this->authorize('update', $landowner);
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
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'floor' => 'exclude_if:type_build,house|required|numeric',
            'floor_number' => 'exclude_if:type_build,house|required|numeric',
            'is_star' => 'nullable',
            'expire_date' => 'required'
        ]);

//        $user = auth()->user();
        $landowner->update([
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
            'rahn_amount' => $request->filled('rahn_amount') ? $request->rahn_amount : 0,
            'rent_amount' => $request->filled('rent_amount') ? $request->rent_amount : 0,
            'selling_price' => $request->filled('selling_price') ? $request->selling_price : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'floor' => $request->filled('floor') ? $request->floor : 0,
            'floor_number' => $$request->filled('floor_number') ? $request->floor_number : 0,
//            'business_id' => $user->business()->id,
//            'user_id' => $user->id,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'expire_date' => $request->expire_date
        ]);

        return redirect()->route('landowner.index',['status' => 'active'])->with('message' , 'فایل موردنظر اپدیت شد.');
    }

    public function destroy(Landowner $landowner)
    {
        $this->authorize('delete', $landowner);

        $landowner->delete();

        return redirect()->back()->with('message' , 'فایل موردنظر حذف شد.');
    }

    public function star(Landowner $landowner)
    {
        $this->authorize('update', $landowner);

        if ($landowner->getRawOriginal('is_star') == 0) {
            $landowner->is_star = 1;
            $landowner->save();
        } else {
            $landowner->is_star = 0;
            $landowner->save();
        }
        return redirect()->back()->with('message' , 'جایگاه فایل موردنظر تغییر کرد.');
    }

    public function setRemainderTime(Request $request){
        $landowner = Landowner::find($request->landowner_id);
        $date = Verta::parse($request->remainder)->datetime()->format('Y-m-d H:i:s');
        $time = new Carbon($date);
        auth()->user()->notify((new ReminderForLandowerNotification($landowner , $date))->delay($time));

        return back()->with('message' , 'یک هشدار برای شما اعمال شد.');
    }

}
