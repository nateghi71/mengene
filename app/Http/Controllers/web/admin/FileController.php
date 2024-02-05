<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\web\LandownerImageController;
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

    public function store(Request $request)
    {
        $this->authorize('adminCreate' , Landowner::class);

        $request->validate([
            'type_file' => 'required',
            'status' => 'required',
            'price' => 'exclude_if:type_file,subscription|exclude_if:type_file,public|required|numeric|between:1000,99999999',
            'type_sale' => 'required',
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
                'user_id' => $user->id,
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


    public function update(Request $request, Landowner $landowner)
    {
        $this->authorize('adminEdit' , Landowner::class);

            $request->validate([
                'type_file' => 'required',
                'status' => 'required',
                'price' => 'exclude_if:type_file,subscription|exclude_if:type_file,public|required|numeric|between:1000,99999999',
                'type_sale' => 'required',
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
//                'user_id' => $user->id,
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
