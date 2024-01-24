<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Models\Landowner;
use App\Models\Province;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
    {
        $this->authorize('adminViewIndex' , Landowner::class);

        $specialLandowners = Landowner::whereNot('type_file' , 'business')->latest()->paginate(10);
        return view('admin.file.index' , compact('specialLandowners'));
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
            'city_id' => 'required',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'type_file' => 'required',
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
            'is_star' => 'nullable',
            'expire_date' => 'required'
        ]);

        $user = auth()->user();
        Landowner::create([
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
            'rahn_amount' => $request->filled('rahn_amount') ? $request->rahn_amount : 0,
            'rent_amount' => $request->filled('rent_amount') ? $request->rent_amount : 0,
            'selling_price' => $request->filled('selling_price') ? $request->selling_price : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'floor' => $request->filled('floor') ? $request->floor : 0,
            'floor_number' => $$request->filled('floor_number') ? $request->floor_number : 0,
            'user_id' => $user->id,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'expire_date' => $request->expire_date
        ]);

        return redirect()->route('admin.files.index')->with('message' , 'فایل موردنظر ایجاد شد.');
    }

    public function show(Landowner $specialLandowner)
    {
        $this->authorize('adminViewShow' , Landowner::class);

        return view('admin.file.show' , compact('specialLandowner'));
    }

    public function edit(Landowner $specialLandowner)
    {
        $this->authorize('adminEdit' , Landowner::class);

        $provinces = Province::all();
        return view('admin.file.edit' , compact('provinces' , 'specialLandowner'));
    }

    public function update(Request $request, Landowner $specialLandowner)
    {
        $this->authorize('adminEdit' , Landowner::class);

        $request->validate([
            'name' => 'required',
            'number' => 'required|iran_mobile',
            'city_id' => 'required',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'type_file' => 'required',
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
            'is_star' => 'nullable',
            'expire_date' => 'required'
        ]);
//        $user = auth()->user();
        $specialLandowner->update([
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
            'rahn_amount' => $request->filled('rahn_amount') ? $request->rahn_amount : 0,
            'rent_amount' => $request->filled('rent_amount') ? $request->rent_amount : 0,
            'selling_price' => $request->filled('selling_price') ? $request->selling_price : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'floor' => $request->filled('floor') ? $request->floor : 0,
            'floor_number' => $$request->filled('floor_number') ? $request->floor_number : 0,
//            'user_id' => $user->id,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'expire_date' => $request->expire_date
        ]);
        return redirect()->route('admin.files.index')->with('message' , 'فایل موردنظر اپدیت شد.');
    }

    public function destroy(Landowner $specialLandowner)
    {
        $this->authorize('adminDelete' , Landowner::class);

        $specialLandowner->delete();
        return redirect()->back()->with('message' , 'فایل موردنظر حذف شد.');;
    }
}
