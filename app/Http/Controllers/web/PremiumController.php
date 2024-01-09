<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Landowner;
use App\Models\Premium;
use App\Models\User;
use Carbon\Carbon;
use Ghasedak\GhasedakApi;
use http\Env\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use App\Models\UserCode;
use Ramsey\Uuid\Generator\PeclUuidNameGenerator;

class PremiumController extends Controller
{
    public function index()
    {
        return view('premium.index');
    }

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

        $premium->update([
            'level' => $request->level,
            'expire_date' => $expire_date,
        ]);

        return redirect()->route('dashboard')->with('message' , 'اکانت شما ارتقا یافت.');
    }
}
