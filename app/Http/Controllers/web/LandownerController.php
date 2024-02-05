<?php

namespace App\Http\Controllers\web;

use App\Events\CreateLandownerFile;
use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\Http\Controllers\Controller;
use App\Http\Requests\LandownerRequest;
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

    public function indexSub()
    {
        $this->authorize('subscription' , Landowner::class);
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
        return view('special_file.index', compact('files'));
    }

    public function show(Landowner $landowner)
    {
        $this->authorize('view', $landowner);
        if ($landowner->getRawOriginal('expire_date') > Carbon::now()) {
            $daysLeft = Carbon::now()->diffInDays($landowner->getRawOriginal('expire_date')) + 1;
            $landowner->daysLeft = $daysLeft;
        }
        return view('landowner.show', compact('landowner'));
    }

    public function create()
    {
        $this->authorize('create', Landowner::class);
        $provinces = Province::all();
        return view('landowner.create' , compact('provinces'));
    }

    public function store(LandownerRequest $request)
    {
        $this->authorize('create', Landowner::class);

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

            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->with('message' , 'فابل ثبت نشد دویاره امتحان کنید.');
        }

        event(new CreateLandownerFile($landowner , $user));

        return redirect()->route('landowner.index',['status' => 'active'])->with('message' , 'فایل موردنظر ایجاد شد.');
    }

    public function edit(Landowner $landowner)
    {
        $this->authorize('update', $landowner);
        $provinces = Province::all();
        return view('landowner.edit', compact('landowner' , 'provinces'));
    }

    public function update(LandownerRequest $request, Landowner $landowner)
    {
        $this->authorize('update', $landowner);

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
        $this->authorize('star', Landowner::class);

        if ($landowner->getRawOriginal('is_star') == 0) {
            $landowner->is_star = 1;
            $landowner->save();
        } else {
            $landowner->is_star = 0;
            $landowner->save();
        }
        return redirect()->back()->with('message' , 'جایگاه فایل موردنظر تغییر کرد.');
    }

    public function checkout(Request $request)
    {
        $this->authorize('subscription' , Landowner::class);
        $landowner = Landowner::findOrFail($request->file_id);
        $landowner->tax = $landowner->filePrice->price * 0.09;
        $landowner->wallet = auth()->user()->business()->wallet;
        $landowner->payment = $landowner->filePrice->price + $landowner->tax;
        $landowner->walletAfterUse = ($landowner->wallet - $landowner->payment) > 0 ?($landowner->wallet - $landowner->payment):0;
        $landowner->paymentAfterWalletUse  = ($landowner->payment - $landowner->wallet) > 0 ? ($landowner->payment - $landowner->wallet):0;

        return view('special_file.checkout' ,compact('landowner'));
    }

    public function setRemainderTime(Request $request){
        $this->authorize('reminder' , Landowner::class);

        $user = auth()->user();
        if($user->isFreeUser() || $user->business()->wallet < 200)
            return back()->with('message' , 'شما به این امکانات دسترسی ندارید.');

        $landowner = Landowner::find($request->landowner_id);
        $date = Verta::parse($request->remainder)->datetime()->format('Y-m-d H:i:s');
        $time = new Carbon($date);
        auth()->user()->notify((new ReminderForLandowerNotification($landowner , $date))->delay($time));

        return back()->with('message' , 'یک هشدار برای شما اعمال شد.');
    }

}
