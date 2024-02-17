<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\web\LandownerImageController;
use App\Http\Requests\LandownerRequest;
use App\Models\Landowner;
use App\Models\PictureLandowner;
use App\Models\Province;
use App\Models\VipFilePrice;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    public function index()
    {
        $this->authorize('adminViewIndex' , Landowner::class);

        $landowners = Landowner::whereNot('type_file' , 'business')->latest()->paginate(10);
        foreach ($landowners as $landowner) {
            if ($landowner->getRawOriginal('expire_date') > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($landowner->getRawOriginal('expire_date')) + 1;
                $landowner->daysLeft = $daysLeft;
            }
        }
        return view('admin.file.index' , compact('landowners'));
    }

    public function create()
    {
        $this->authorize('adminCreate' , Landowner::class);

        $provinces = Province::all();
        return view('admin.file.create' , compact('provinces'));
    }

    public function store(LandownerRequest $request)
    {
        $this->authorize('adminCreate' , Landowner::class);

//        $request->validate([
//            'type_file' => 'required',
//            'status' => 'required',
//            'price' => 'exclude_if:type_file,subscription|exclude_if:type_file,public|required|numeric|between:1000,99999999',
//            'type_sale' => 'required',
//            'name' => 'required',
//            'number' => 'required|iran_mobile',
//            'scale' => 'required|numeric',
//            'city_id' => 'required|numeric',
//            'area' => 'required|numeric',
//            'expire_date' => 'required',
//            'selling_price' => 'exclude_if:type_sale,rahn|required',
//            'rahn_amount' => 'exclude_if:type_sale,buy|required',
//            'rent_amount' => 'exclude_if:type_sale,buy|required',
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
//            'images' => 'nullable',
//            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

        try{
            DB::beginTransaction();

            $user = auth()->user();
            $landowner = Landowner::create([
                'type_file' => $request->type_file,
                'access_level' => $request->type_file == 'public' ? 'public' : 'private',
                'status' => $request->status,

                'type_sale' => $request->type_sale,
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

            if($request->images !== null)
            {
                $imageController = new LandownerImageController();
                $imageController->store($request->images , $landowner);
            }

            if($request->type_file == 'buy')
            {
                $landowner->filePrice()->create([
                    'price' =>  $request->price !== null ? $request->price : 0,
                ]);
            }

            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            dd($e->getMessage());
            return back()->with('message' , 'فابل ثبت نشد دویاره امتحان کنید.');
        }

        return redirect()->route('admin.landowners.index')->with('message' , 'فایل موردنظر ایجاد شد.');
    }

    public function show(Landowner $landowner)
    {
        $this->authorize('adminViewShow' , Landowner::class);
        if ($landowner->getRawOriginal('expire_date') > Carbon::now()) {
            $daysLeft = Carbon::now()->diffInDays($landowner->getRawOriginal('expire_date')) + 1;
            $landowner->daysLeft = $daysLeft;
        }
        return view('admin.file.show' , compact('landowner'));
    }

    public function edit(Landowner $landowner)
    {
        $this->authorize('adminEdit' , Landowner::class);

        $provinces = Province::all();
        return view('admin.file.edit' , compact('provinces' , 'landowner'));
    }

    public function editImage(Landowner $landowner)
    {
        $this->authorize('adminEdit' , Landowner::class);
        return view('admin.file.edit_image' , compact('landowner'));
    }


    public function update(LandownerRequest $request, Landowner $landowner)
    {
        $this->authorize('adminEdit' , Landowner::class);

//            $request->validate([
//                'type_file' => 'required',
//                'status' => 'required',
//                'price' => 'exclude_if:type_file,subscription|exclude_if:type_file,public|required|numeric|between:1000,99999999',
//                'type_sale' => 'required',
//                'name' => 'required',
//                'number' => 'required|iran_mobile',
//                'scale' => 'required|numeric',
//                'city_id' => 'required|numeric',
//                'area' => 'required|numeric',
//                'expire_date' => 'required',
//                'selling_price' => 'exclude_if:type_sale,rahn|required',
//                'rahn_amount' => 'exclude_if:type_sale,buy|required',
//                'rent_amount' => 'exclude_if:type_sale,buy|required',
//                'type_work' => 'required',
//                'type_build' => 'required',
//                'document' => 'exclude_if:type_sale,rahn|required',
//                'address' => 'required',
//                //more
//                'year_of_construction' => 'exclude_if:type_build,land|nullable|numeric',
//                'year_of_reconstruction' => 'exclude_if:type_build,land|nullable|numeric',
//                'number_of_rooms' => 'exclude_if:type_build,land|nullable|numeric',
//                'floor_number' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
//                'floor' => 'exclude_if:type_build,land|nullable|numeric',
//                'floor_covering' => 'exclude_if:type_build,land|nullable',
//                'cooling' => 'exclude_if:type_build,land|nullable',
//                'heating' => 'exclude_if:type_build,land|nullable',
//                'cabinets' => 'exclude_if:type_build,land|nullable',
//                'view' => 'exclude_if:type_build,land|nullable',
//                'number_of_unit_in_floor' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
//                'number_unit' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
//                'postal_code' => 'exclude_if:type_build,land|nullable|numeric',
//                'plaque' => 'exclude_if:type_build,land|nullable|numeric',
//                'state_of_electricity' => 'exclude_if:type_build,land|nullable',
//                'state_of_water' => 'exclude_if:type_build,land|nullable',
//                'state_of_gas' => 'exclude_if:type_build,land|nullable',
//                'state_of_phone' => 'exclude_if:type_build,land|nullable',
//                'Direction_of_building' => 'exclude_if:type_build,land|nullable',
//                'water_heater' => 'exclude_if:type_build,land|nullable',
//                'description' => 'nullable',
//                'images' => 'nullable',
//                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//
//                'discharge' => 'exclude_if:type_build,land|nullable',
//                'elevator' => 'exclude_if:type_build,land|nullable',
//                'parking' => 'exclude_if:type_build,land|nullable',
//                'store' => 'exclude_if:type_build,land|nullable',
//                'is_star' => 'exclude_if:type_build,land|nullable',
//                'exist_owner' => 'exclude_if:type_build,land|nullable',
//                'terrace' => 'exclude_if:type_build,land|nullable',
//                'air_conditioning_system' => 'exclude_if:type_build,land|nullable',
//                'yard' => 'exclude_if:type_build,land|nullable',
//                'pool' => 'exclude_if:type_build,land|nullable',
//                'sauna' => 'exclude_if:type_build,land|nullable',
//                'Jacuzzi' => 'exclude_if:type_build,land|nullable',
//                'video_iphone' => 'exclude_if:type_build,land|nullable',
//                'Underground' => 'exclude_if:type_build,land|nullable',
//                'Wall_closet' => 'exclude_if:type_build,land|nullable',
//            ]);

        try{
            DB::beginTransaction();
    //        $user = auth()->user();
            $landowner->update([
                'type_file' => $request->type_file,
                'access_level' => $request->type_file == 'public' ? 'public' : 'private',
                'status' => $request->status,

                'type_sale' => $request->type_sale,
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
//                'user_id' => $user->id,

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

            if($request->type_file == 'buy')
            {
                VipFilePrice::updateOrCreate(['landowner_id' => $landowner->id],['price' => $request->price]);
            }
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->with('message' , 'فابل ثبت نشد دویاره امتحان کنید.');
        }

        return redirect()->route('admin.landowners.index')->with('message' , 'فایل موردنظر اپدیت شد.');
    }

    public function destroy(Landowner $landowner)
    {
        $this->authorize('adminDelete' , Landowner::class);

        $landowner->delete();
        return redirect()->back()->with('message' , 'فایل موردنظر حذف شد.');;
    }
}
