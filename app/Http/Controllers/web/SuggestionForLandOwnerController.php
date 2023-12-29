<?php

namespace App\Http\Controllers\web;

use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Landowner;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuggestionForLandOwnerController extends Controller
{
    public function suggested_customer(Landowner $landowner)
    {
        $business = $landowner->user->business()->first();
        $landownerId = $landowner->id;
        if ($landowner->type_sale == 'buy')
        {
            $minPrice = $landowner->selling_price * 0.8; // 80% of the customer's price
            $maxPrice = $landowner->selling_price * 1.2; // 120% of the customer's price

            $suggestions = Customer::where('status', 'active')->where('business_id', $business->id)
                ->whereDoesntHave('suggestedLandowner', function ($query) use ($landownerId) {
                    $query->where('landowner_id', $landownerId)->where('suggest_business' , 1);
                })->whereBetween('selling_price', [$minPrice, $maxPrice])->orderBy('selling_price' , 'asc')->limit(10)->get();
        }
        else
        {
            //20% diff
            $minRahn = $landowner->rahn_amount * 0.8;
            $maxRahn = $landowner->rahn_amount * 1.2;
            $minRent = $landowner->rent_amount * 0.8;
            $maxRent = $landowner->rent_amount * 1.2;

            $suggestions = Customer::where('status', 'active')->where('business_id', $business->id)
                ->whereDoesntHave('suggestedLandowner', function ($query) use ($landownerId) {
                    $query->where('landowner_id', $landownerId)->where('suggest_business' , 1);
                })->whereBetween('rahn_amount', [$minRahn, $maxRahn])
                ->whereBetween('rent_amount', [$minRent, $maxRent])->orderBy('rahn_amount' , 'asc')
                ->orderBy('rent_amount' , 'asc')->limit(10)->get();
        }

        foreach ($suggestions as $suggestion) {
            if ($suggestion->expire_date > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($suggestion->expire_date) + 1;
                $suggestion->daysLeft = $daysLeft;
            }
        }


        return view('landowner.suggestion' , compact('suggestions' ,'landowner'));
    }

    public function send_block_message(Request $request)
    {
        $request->validate([
            'landowner_id' => 'required',
            'customer_id' => 'required'
        ]);

        $landowner = Landowner::findOrFail($request->landowner_id);

        $link = new LinkGenerator();
        $link = $link->generateLinkForLandowner($landowner , 'remove_from_suggestion' , $request->customer_id);
        $link = route('confirmation.confirmPage' ,
            ['type' => $link->type , 'token' => $link->token]);

        $smsApi = new SmsAPI();
//        $smsApi->sendSmsLink($landowner->number , $link);

        return redirect()->back();
    }
}
