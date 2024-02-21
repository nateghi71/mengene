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
use Illuminate\Support\Facades\Hash;

class PremiumController extends Controller
{
    use MyBaseController;

    public function store($business)
    {
        $package = Package::where('name' , 'free')->first();
        $business->premium()->create([
            'package_id' => $package->id,
            'expire_date' => Carbon::now()->addMonth($package->time),
        ]);
    }

    public function package_name()
    {
        return auth()->user()->business()->premium->package->name;
    }

    public function get_package(Request $request)
    {
//        try
//        {
//            $this->authorize('viewPremiumIndex' , Business::class);
//        }
//        catch (AuthorizationException $exception)
//        {
//            return $this->sendError('Authorization Error', $exception->getMessage() , 401);
//        }

        if(Hash::check($request->str_key , '$2y$12$fDryj4vnzYd.6GNFKa2ifufPGNtfVEDI8lmlvgkv51NUaesx8sS0G'))
        {
            $package = Package::where('name' , $request->package_name)->first();

            $business = auth()->user()->ownedBusiness()->first();
            $premium = Premium::where('business_id' , $business->id)->first();
            $expire_date = Carbon::now()->addMonth($package->time);

            $premium->update([
                'package_id' => $package->id,
                'expire_date' => $expire_date,
            ]);

            return $this->sendResponse([], 'Package Is Buy.');
        }

        return $this->sendError('Unauthorised.', ['error' => 'Unauthorised2'] , 422);
    }
}
