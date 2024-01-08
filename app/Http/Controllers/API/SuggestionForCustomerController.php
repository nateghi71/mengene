<?php

namespace App\Http\Controllers\API;

use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\Http\Controllers\API\MyBaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\LandownerResource;
use App\Models\Customer;
use App\Models\Landowner;
use Illuminate\Http\Request;

class SuggestionForCustomerController extends BaseController
{
    public function suggested_landowner(Customer $customer)
    {
        $business = $customer->business()->first();
        $customerId = $customer->id;

        if ($customer->getRawOriginal('type_sale') == 'buy')
        {
            $minPrice = $customer->getRawOriginal('selling_price') * 0.8; // 80% of the customer's price
            $maxPrice = $customer->getRawOriginal('selling_price') * 1.2; // 120% of the customer's price

            $suggestions = Landowner::where('status', 'active')->where('business_id', $business->id)
                ->whereDoesntHave('suggestedCustomer', function ($query) use ($customerId) {
                    $query->where('customer_id', $customerId)->where('suggest_business' , 1);
                })->whereBetween('selling_price', [$minPrice, $maxPrice])->orderBy('selling_price' , 'asc')->limit(10)->get();
        }
        else
        {
            //20% diff
            $minRahn = $customer->getRawOriginal('rahn_amount') * 0.8;
            $maxRahn = $customer->getRawOriginal('rahn_amount') * 1.2;
            $minRent = $customer->getRawOriginal('rent_amount') * 0.8;
            $maxRent = $customer->getRawOriginal('rent_amount') * 1.2;

            $suggestions = Landowner::where('status', 'active')->where('business_id', $business->id)
                ->whereDoesntHave('suggestedCustomer', function ($query) use ($customerId) {
                    $query->where('customer_id', $customerId)->where('suggest_business' , 1);
                })->whereBetween('rahn_amount', [$minRahn, $maxRahn])
                ->whereBetween('rent_amount', [$minRent, $maxRent])->orderBy('rahn_amount' , 'asc')
                ->orderBy('rent_amount' , 'asc')->limit(10)->get();
        }

        return $this->sendResponse([
            'Suggestions' => LandownerResource::collection($suggestions),
        ], 'Suggestions retrieved successfully.');
    }

    public function send_block_message(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'landowner_id' => 'required'
        ]);

        $customer = Customer::findOrFail($request->customer_id);

        $link = new LinkGenerator();
        $link = $link->generateLinkForCustomer($customer , 'remove_from_suggestion' , 30, $request->landowner_id);
        $link = route('confirmation.confirmPage' ,
            ['type' => $link->type , 'token' => $link->token]);

        $smsApi = new SmsAPI();
        $smsApi->sendSmsLink($customer->number , $customer->name , $link);

        return $this->sendResponse(['link' => $link], 'message send successfully.');
    }
}
