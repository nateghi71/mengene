<?php

namespace App\Http\Controllers\web;

use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Landowner;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecialLandownerController extends Controller
{
    public function index()
    {
        $this->authorize('subscription' , Landowner::class);
        $user = auth()->user();
        $city_id = $user->business()->city_id;
        $area = $user->business()->area;

        $files = Landowner::whereNull('business_id')->whereNot('access_level' , 'public')->where('city_id' , $city_id)->where('area' , $area)
            ->where('expire_date' , '>' , Carbon::now())->orderBy('type_file')->filter()->paginate(10)->withQueryString();

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
        $this->authorize('subscription', $landowner);
        return view('special_file.show', compact('landowner'));
    }

    public function buyFile(Landowner $landowner)
    {
        $this->authorize('subscription' , Landowner::class);
        $user = auth()->user();
        $landowner->update([
            'type_file' => 'business' ,
            'business_id' => $user->business()->id,
            'user_id' => $user->id,
        ]);
        return back()->with('message' , 'فایل موردنظر با موفقیت خریداری شد');
    }
}
