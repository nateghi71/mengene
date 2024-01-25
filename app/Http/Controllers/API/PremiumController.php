<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Premium;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PremiumController extends BaseController
{
    public function store($business)
    {
        $business->premium()->create([
            'level' => 'free',
            'expire_date' => Carbon::now()->addDecade(),
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('viewBusinessIndex' , Business::class);
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

        $data['premium'] = $premium;
        return $this->sendResponse($data, 'User register successfully.');
    }


}
