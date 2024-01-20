<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\SpecialFile;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function index()
    {
        $files = SpecialFile::latest()->paginate(10);
        return view('admin.file.index' , compact('files'));
    }

    public function create()
    {
        $provinces = Province::all();
        return view('admin.file.create' , compact('provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required|numeric',
            'city_id' => 'required',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'scale' => 'required',
            'number_of_rooms' => 'required|numeric',
            'description' => 'required',
            'rahn_amount' => 'exclude_if:type_sale,buy',
            'rent_amount' => 'exclude_if:type_sale,buy',
            'selling_price' => 'exclude_if:type_sale,rahn',
            'type_file' => 'required',
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'floor' => 'required|numeric',
            'floor_number' => 'required|numeric',
            'is_star' => 'nullable',
            'expire_date' => 'required'
        ]);

//        $user = auth()->user();
        SpecialFile::create([
            'name' => $request->name,
            'number' => $request->number,
            'city_id' => $request->city_id,
            'type_sale' => $request->type_sale,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'scale' => $request->scale,
            'number_of_rooms' => $request->number_of_rooms,
            'description' => $request->description,
            'type_file' => $request->type_file,
            'rahn_amount' => $request->filled('rahn_amount') ? $request->rahn_amount : 0,
            'rent_amount' => $request->filled('rent_amount') ? $request->rent_amount : 0,
            'selling_price' => $request->filled('selling_price') ? $request->selling_price : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'floor' => $request->floor,
            'floor_number' => $request->floor_number,
//            'user_id' => $user->id,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'expire_date' => $request->expire_date
        ]);

        return redirect()->route('admin.files.index')->with('message' , 'فایل موردنظر ایجاد شد.');

    }

    public function show(SpecialFile $file)
    {
        return view('admin.file.show' , compact('file'));
    }

    public function edit(SpecialFile $file)
    {
        $provinces = Province::all();
        return view('admin.file.edit' , compact('provinces' , 'file'));
    }

    public function update(Request $request, SpecialFile $file)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required|numeric',
            'city_id' => 'required',
            'type_sale' => 'required',
            'type_work' => 'required',
            'type_build' => 'required',
            'scale' => 'required',
            'number_of_rooms' => 'required|numeric',
            'description' => 'required',
            'access_level' => 'required',
            'rahn_amount' => 'exclude_if:type_sale,buy',
            'rent_amount' => 'exclude_if:type_sale,buy',
            'selling_price' => 'exclude_if:type_sale,rahn',
            'elevator' => 'sometimes|nullable',
            'parking' => 'sometimes|nullable',
            'store' => 'sometimes|nullable',
            'floor' => 'required|numeric',
            'floor_number' => 'required|numeric',
            'is_star' => 'sometimes|nullable',
            'expire_date' => 'required'
        ]);
//        $user = auth()->user();
        $file->update([
            'name' => $request->name,
            'number' => $request->number,
            'city_id' => $request->city_id,
            'type_sale' => $request->type_sale,
            'type_work' => $request->type_work,
            'type_build' => $request->type_build,
            'scale' => $request->scale,
            'number_of_rooms' => $request->number_of_rooms,
            'description' => $request->description,
            'access_level' => $request->access_level,
            'rahn_amount' => $request->filled('rahn_amount') ? $request->rahn_amount : 0,
            'rent_amount' => $request->filled('rent_amount') ? $request->rent_amount : 0,
            'selling_price' => $request->filled('selling_price') ? $request->selling_price : 0,
            'elevator' => $request->has('elevator') ? 1 : 0,
            'parking' => $request->has('parking') ? 1 : 0,
            'store' => $request->has('store') ? 1 : 0,
            'floor' => $request->floor,
            'floor_number' => $request->floor_number,
//            'business_id' => $user->business()->id,
//            'user_id' => $user->id,
            'is_star' => $request->has('is_star') ? 1 : 0 ,
            'expire_date' => $request->expire_date
        ]);
        return redirect()->route('admin.files.index')->with('message' , 'فایل موردنظر اپدیت شد.');

    }

    public function destroy(SpecialFile $file)
    {
        $file->delete();

        return redirect()->back()->with('message' , 'فایل موردنظر حذف شد.');;

    }
}
