<?php

namespace App\Http\Controllers\web;

use App\HelperClasses\BlockSuggestion;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Landowner;
use App\Models\RandomLink;
use App\Models\Suggestion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RandomLinkController extends Controller
{
    public function confirmPage($type , $token)
    {
        $randomLink = RandomLink::where('token', $token)->where('type', $type)->first();
        $requestedPerson = $randomLink->linkable;
        $suggestionPerson = null;

        if($randomLink->type === 'remove_from_suggestion')
        {
            if($randomLink->linkable instanceof Landowner)
            {
                $suggestionPerson = Customer::findOrFail($randomLink->suggest_id);
            }
            elseif ($randomLink->linkable instanceof Customer)
            {
                $suggestionPerson = Landowner::findOrFail($randomLink->suggest_id);
            }
        }

//        dd($suggestionPerson);

        return view('confirmation.confirm' , compact('type' , 'token' , 'requestedPerson' , 'suggestionPerson'));
    }
    public function handleExpired(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'type' => 'required',
            'response' => 'required'
        ]);

        $randomLink = RandomLink::where('token', $request->token)->first();
        $requestedPerson = $randomLink->linkable;


        if($request->response == 1)
        {
            $message = "زمان باقیمانده شما تمدید شد.";
            $requestedPerson->ignoreMutator = true;
            $requestedPerson->update([
                'expire_date' => Carbon::now()->addDays(30)->toDate(),
                'status' => 'active'
            ]);
        }
        elseif($request->response == 0)
        {
            $message = "از همکاری با شما خوشحال شدیم.";
            $requestedPerson->update([
                'status' => 'deActive'
            ]);
            $requestedPerson->delete();
        }

        $randomLink->delete();
        return view('confirmation.message', ['message' => $message]);
    }

    public function handleSuggestion(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'type' => 'required',
            'response' => 'required'
        ]);
//        dd($request->all());
        $randomLink = RandomLink::where('token', $request->token)->first();

        $message = "مشترک موردنظر همچنان در لیست پیشنهادات باقی می ماند.";

        if($request->response == 0)
        {
            if($randomLink->linkable instanceof Landowner)
            {
                $message = "مشتری موردنظر از لیست پیشنهادات حذف شد.";

                $landowner = $randomLink->linkable;
                $customer = Customer::findOrFail($randomLink->suggest_id);
                $landowner->suggestedCustomer()->attach($customer->id ,
                    ['business_id' => $landowner->business_id , 'suggest_business' => 1 , 'suggest_all' => 0]);
            }
            elseif ($randomLink->linkable instanceof Customer)
            {
                $message = "خانه موردنظر از لیست پیشنهادات حذف شد.";

                $customer = $randomLink->linkable;
                $landowner = Landowner::findOrFail($randomLink->suggest_id);
                $customer->suggestedLandowner()->attach($landowner->id ,
                    ['business_id' => $customer->business_id , 'suggest_business' => 1 , 'suggest_all' => 0]);
            }
        }

        $randomLink->delete();
        return view('confirmation.message', ['message' => $message]);
    }
}
