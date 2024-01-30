<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\web\LandownerImageController;
use App\Models\Landowner;
use App\Models\Province;
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
            'name' => 'required',
            'number' => 'required|iran_mobile',
            'city_id' => 'required|numeric',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'type_file' => 'required',
            'price' => 'exclude_if:type_file,subscription|exclude_if:type_file,public|required|numeric',
            'scale' => 'required|numeric',
            'area' => 'required|numeric',
            'number_of_rooms' => 'required|numeric',
            'description' => 'required',
            'rahn_amount' => 'exclude_if:type_sale,buy|required',
            'rent_amount' => 'exclude_if:type_sale,buy|required',
            'selling_price' => 'exclude_if:type_sale,rahn|required',
            'status' => 'required',
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'floor' => 'exclude_if:type_build,house|required|numeric',
            'floor_number' => 'exclude_if:type_build,house|required|numeric',
            'expire_date' => 'required',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try{
            DB::beginTransaction();

            $user = auth()->user();
            $landowner = Landowner::create([
                'name' => $request->name,
                'number' => $request->number,
                'city_id' => $request->city_id,
                'type_sale' => $request->type_sale,
                'type_work' => $request->type_work,
                'type_build' => $request->type_build,
                'type_file' => $request->type_file,
                'access_level' => $request->type_file == 'public' ? 'public' : 'private',
                'scale' => $request->scale,
                'number_of_rooms' => $request->number_of_rooms,
                'description' => $request->description,
                'status' => $request->status,
                'area' => $request->area,
                'rahn_amount' => ($request->type_sale === 'rahn' && $request->rahn_amount !== null) ? $request->rahn_amount : 0,
                'rent_amount' => ($request->type_sale === 'rahn' && $request->rent_amount !== null) ? $request->rent_amount : 0,
                'selling_price' => ($request->type_sale === 'buy' && $request->selling_price !== null) ? $request->selling_price : 0,
                'elevator' => $request->has('elevator') ? 1 : 0,
                'parking' => $request->has('parking') ? 1 : 0,
                'store' => $request->has('store') ? 1 : 0,
                'floor' => ($request->type_build === 'apartment' && $request->floor !== null) ? $request->floor : 0,
                'floor_number' => ($request->type_build === 'apartment' && $request->floor_number !== null) ? $request->floor_number : 0,
                'user_id' => $user->id,
                'is_star' => $request->has('is_star') ? 1 : 0 ,
                'expire_date' => $request->expire_date
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
            return back()->with('message' , 'فابل ثبت نشد دویاره امتحان کنید.');
        }

        return redirect()->route('admin.landowners.index')->with('message' , 'فایل موردنظر ایجاد شد.');
    }

    public function show(Landowner $landowner)
    {
        $this->authorize('adminViewShow' , Landowner::class);
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
        return view('admin.file.edit_image' , compact('landowner'));
    }


    public function update(Request $request, Landowner $landowner)
    {
        $this->authorize('adminEdit' , Landowner::class);

            $request->validate([
            'name' => 'required',
            'number' => 'required|iran_mobile',
            'city_id' => 'required|numeric',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'type_file' => 'required',
            'price' => 'exclude_if:type_file,subscription|exclude_if:type_file,public|required|numeric',
            'scale' => 'required',
            'area' => 'required|numeric',
            'number_of_rooms' => 'required|numeric',
            'description' => 'required',
            'rahn_amount' => 'exclude_if:type_sale,buy|required',
            'rent_amount' => 'exclude_if:type_sale,buy|required',
            'selling_price' => 'exclude_if:type_sale,rahn|required',
            'status' => 'required',
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'floor' => 'exclude_if:type_build,house|required|numeric',
            'floor_number' => 'exclude_if:type_build,house|required|numeric',
            'expire_date' => 'required'
        ]);

        try{
            DB::beginTransaction();
    //        $user = auth()->user();
            $landowner->update([
                'name' => $request->name,
                'number' => $request->number,
                'city_id' => $request->city_id,
                'type_sale' => $request->type_sale,
                'type_work' => $request->type_work,
                'type_build' => $request->type_build,
                'type_file' => $request->type_file,
                'access_level' => $request->type_file == 'public' ? 'public' : 'private',
                'scale' => $request->scale,
                'number_of_rooms' => $request->number_of_rooms,
                'description' => $request->description,
                'status' => $request->status,
                'area' => $request->area,
                'rahn_amount' => ($request->type_sale === 'rahn' && $request->rahn_amount !== null) ? $request->rahn_amount : 0,
                'rent_amount' => ($request->type_sale === 'rahn' && $request->rent_amount !== null) ? $request->rent_amount : 0,
                'selling_price' => ($request->type_sale === 'buy' && $request->selling_price !== null) ? $request->selling_price : 0,
                'elevator' => $request->has('elevator') ? 1 : 0,
                'parking' => $request->has('parking') ? 1 : 0,
                'store' => $request->has('store') ? 1 : 0,
                'floor' => ($request->type_build === 'apartment' && $request->floor !== null) ? $request->floor : 0,
                'floor_number' => ($request->type_build === 'apartment' && $request->floor_number !== null) ? $request->floor_number : 0,
    //            'user_id' => $user->id,
                'expire_date' => $request->expire_date
            ]);

            if($request->type_file == 'buy')
            {
                $landowner->filePrice()->update([
                    'price' =>  $request->price !== null ? $request->price : 0,
                ]);
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
