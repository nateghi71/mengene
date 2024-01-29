<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Landowner;
use App\Models\PictureLandowner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class LandownerImageController extends BaseController
{
    public function store($images , $landowner)
    {
        $imageNames = array();
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
    public function add(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'add_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error', $validator->errors() , 400);
        }

        $fileName = generateFileName($request->add_image->getClientOriginalName());
        $request->add_image->move(public_path(env('LANDOWNER_IMAGES_UPLOAD_PATH')),$fileName);
        $landowner = Landowner::findOrFail($request->landowner_id);
        $landowner->images()->create([
            'image' => $fileName,
        ]);

        return $this->sendResponse(['images' => $landowner->images], 'landowner images.');
    }

    public function destroy(Request $request)
    {
        $image = PictureLandowner::find($request->image_id);
        $landowner = Landowner::find($request->landowner_id);

        if(File::exists(public_path(env('LANDOWNER_IMAGES_UPLOAD_PATH')).$image->image)){
            File::delete(public_path(env('LANDOWNER_IMAGES_UPLOAD_PATH')).$image->image);
        }

        $image->delete();
        return $this->sendResponse(['images' => $landowner->images], 'landowner images.');
    }
}
