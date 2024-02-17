<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Package;
use App\Models\Premium;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class PremiumController extends BaseController
{
    public function store($business)
    {
        $package = Package::where('name' , 'free')->first();
        $business->premium()->create([
            'package_id' => $package->id,
            'expire_date' => Carbon::now()->addMonth($package->time),
        ]);
    }

    public function update(Request $request)
    {
        try
        {
            $this->authorize('viewPremiumIndex' , Business::class);
        }
        catch (AuthorizationException $exception)
        {
            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
        }

        $business = auth()->user()->ownedBusiness()->first();
        $premium = Premium::where('business_id' , $business->id)->first();

        $expire_date = Carbon::now()->addMonth(3);
        if($request->level == 'midLevel')
        {
            $expire_date = Carbon::now()->addMonth(3);
        }
        elseif ($request->level == 'vip')
        {
            $expire_date = Carbon::now()->addYear();
        }

        $premium = $premium->update([
            'level' => $request->level,
            'expire_date' => $expire_date,
        ]);

        return $this->sendResponse(['level' => $premium->level], 'premium buy successfully.');
    }


}
