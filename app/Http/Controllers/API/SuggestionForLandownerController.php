<?php

namespace App\Http\Controllers\API;

use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\Landowner;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuggestionForLandownerController extends BaseController
{
    public function suggested_customer(Landowner $landowner)
    {
        $business = auth()->user()->business();
        $landownerId = $landowner->id;
        if ($landowner->getRawOriginal('type_sale') == 'buy')
        {
            $minPrice = $landowner->getRawOriginal('selling_price') * 0.8; // 80% of the customer's price
            $maxPrice = $landowner->getRawOriginal('selling_price') * 1.2; // 120% of the customer's price

            $businessSuggestions = $business->customers()->whereNot('status', 'deActive')->where('type_sale', 'buy')
                ->whereDoesntHave('dontSuggestedLandowner', function ($query) use ($landownerId) {
                    $query->where('landowner_id', $landownerId)->where('suggest_business' , 1);
                })->whereBetween('selling_price', [$minPrice, $maxPrice])->orderBy('selling_price' , 'asc')->limit(10)->get();

            $specialSuggestions = Customer::whereNull('business_id')->where('city_id' , $business->city_id)->where('area' , $business->area)
                ->where('type_sale', 'buy')->whereDoesntHave('dontSuggestedLandowner', function ($query) use ($landownerId) {
                    $query->where('landowner_id', $landownerId)->where('suggest_business' , 1);
                })->whereBetween('selling_price', [$minPrice, $maxPrice])->orderBy('selling_price' , 'asc')->limit(10)->get();

            $suggestions = $businessSuggestions->concat($specialSuggestions);
        }
        else
        {
            //20% diff
            $minRahn = $landowner->getRawOriginal('rahn_amount') * 0.8;
            $maxRahn = $landowner->getRawOriginal('rahn_amount') * 1.2;
            $minRent = $landowner->getRawOriginal('rent_amount') * 0.8;
            $maxRent = $landowner->getRawOriginal('rent_amount') * 1.2;

            $businessSuggestions = $business->customers()->whereNot('status', 'deActive')->where('type_sale', 'rahn')
                ->whereDoesntHave('dontSuggestedLandowner', function ($query) use ($landownerId) {
                    $query->where('landowner_id', $landownerId)->where('suggest_business' , 1);
                })->whereBetween('rahn_amount', [$minRahn, $maxRahn])
                ->whereBetween('rent_amount', [$minRent, $maxRent])->orderBy('rahn_amount' , 'asc')
                ->orderBy('rent_amount' , 'asc')->limit(10)->get();

            $specialSuggestions = Customer::whereNull('business_id')->where('city_id' , $business->city_id)->where('area' , $business->area)
                ->where('type_sale', 'rahn')->whereDoesntHave('dontSuggestedLandowner', function ($query) use ($landownerId) {
                    $query->where('landowner_id', $landownerId)->where('suggest_business' , 1);
                })->whereBetween('rahn_amount', [$minRahn, $maxRahn])
                ->whereBetween('rent_amount', [$minRent, $maxRent])->orderBy('rahn_amount' , 'asc')
                ->orderBy('rent_amount' , 'asc')->limit(10)->get();

            $suggestions = $businessSuggestions->concat($specialSuggestions);
        }

        foreach ($suggestions as $suggestion) {
            if ($suggestion->getRawOriginal('expire_date') > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($suggestion->getRawOriginal('expire_date')) + 1;
                $suggestion->daysLeft = $daysLeft;
            }
        }
        return $this->sendResponse([
            'Suggestions' => CustomerResource::collection($suggestions),
        ], 'Suggestions retrieved successfully.');
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
        $smsApi->sendSmsLink($landowner->number ,$landowner->name , $link);

        return $this->sendResponse(['link' => $link], 'message send successfully.');
    }

    public function share_file_with_customer(Request $request)
    {
        $user = auth()->user();
        if($user->isVipUser() || ($user->isMidLevelUser() && $user->getPremiumCountSms() <= 1000))
        {
            $user->incrementPremiumCountSms();
            $landowner = Landowner::findOrFile($request->landowner_id);
            $customer = Customer::findOrFile($request->customer_id);
            if($customer->getRawOriginal('type_sale') == 'rahn')
                $price = $customer->rahn_amount.'/'.$customer->rent_amount;
            else
                $price = $customer->selling_price;
            $smsApi = new SmsAPI();
            $smsApi->sendSmsShareFile($landowner->number ,$landowner->name , $customer->scale , $price  , $landowner->business->number);
            return $this->sendResponse([], 'message send successfully.');
        }
        else
        {
            return $this->sendResponse([], 'you are not ability for send message');
        }
    }


}
