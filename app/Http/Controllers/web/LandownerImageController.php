<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Landowner;
use App\Models\PictureLandowner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LandownerImageController extends Controller
{
    public function store($images , $landowner)
    {
        $imageNames = null;
        foreach ($images as $image) {
            $imageName = generateFileName($image->getClientOriginalName());
            $image->move(public_path(env('LANDOWNER_IMAGES_UPLOAD_PATH')), $imageName);
            $imageNames[] = $imageName;
        }

        foreach ($imageNames as $imageName) {
            PictureLandowner::create([
                'landowner_id' => $landowner->id,
                'image' => $imageName,
            ]);
        }
    }

    public function edit(Landowner $landowner)
    {
        $this->authorize('update' , $landowner);
        return view('landowner.edit_image' , compact('landowner'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'add_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $fileName = generateFileName($request->add_image->getClientOriginalName());
        $request->add_image->move(public_path(env('LANDOWNER_IMAGES_UPLOAD_PATH')),$fileName);
        $landowner = Landowner::findOrFail($request->landowner_id);
        $landowner->images()->create([
            'image' => $fileName,
        ]);
        return ['images' => $landowner->images];
    }


    public function destroy(Request $request)
    {
        $image = PictureLandowner::find($request->image_id);
        $landowner = Landowner::find($request->landowner_id);

        if(File::exists(public_path(env('LANDOWNER_IMAGES_UPLOAD_PATH')).$image->image)){
            File::delete(public_path(env('LANDOWNER_IMAGES_UPLOAD_PATH')).$image->image);
        }

        $image->delete();
        return ['images' => $landowner->images];
    }
}
