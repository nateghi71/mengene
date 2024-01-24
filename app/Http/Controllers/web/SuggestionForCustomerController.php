<?php

namespace App\Http\Controllers\web;

use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Landowner;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SuggestionForCustomerController extends Controller
{
    public function suggested_landowner(Customer $customer)
    {
        $business = auth()->user()->business();
        $customerId = $customer->id;
        if ($customer->getRawOriginal('type_sale') == 'buy')
        {
            $minPrice = $customer->getRawOriginal('selling_price') * 0.8; // 80% of the customer's price
            $maxPrice = $customer->getRawOriginal('selling_price') * 1.2; // 120% of the customer's price

            $businessSuggestions = $business->landowners()->whereNot('status', 'deActive')->where('type_sale', 'buy')
                ->whereDoesntHave('dontSuggestedCustomer', function ($query) use ($customerId) {
                    $query->where('customer_id', $customerId)->where('suggest_business' , 1);
                })->whereBetween('selling_price', [$minPrice, $maxPrice])->orderBy('selling_price' , 'asc')->limit(10)->get();

            $specialSuggestions = Landowner::whereNull('business_id')->where('city_id' , $business->city_id)->where('area' , $business->area)
                ->where('type_sale', 'buy')->whereDoesntHave('dontSuggestedCustomer', function ($query) use ($customerId) {
                    $query->where('customer_id', $customerId)->where('suggest_business' , 1);
                })->whereBetween('selling_price', [$minPrice, $maxPrice])->orderBy('selling_price' , 'asc')->limit(10)->get();

            $suggestions = $businessSuggestions->concat($specialSuggestions);
        }
        else
        {
            //20% diff
            $minRahn = $customer->getRawOriginal('rahn_amount') * 0.8;
            $maxRahn = $customer->getRawOriginal('rahn_amount') * 1.2;
            $minRent = $customer->getRawOriginal('rent_amount') * 0.8;
            $maxRent = $customer->getRawOriginal('rent_amount') * 1.2;

            $businessSuggestions = $business->landowners()->whereNot('status', 'deActive')->where('type_sale', 'rahn')
                ->whereDoesntHave('dontSuggestedCustomer', function ($query) use ($customerId) {
                    $query->where('customer_id', $customerId)->where('suggest_business' , 1);
                })->whereBetween('rahn_amount', [$minRahn, $maxRahn])
                ->whereBetween('rent_amount', [$minRent, $maxRent])->orderBy('rahn_amount' , 'asc')
                ->orderBy('rent_amount' , 'asc')->limit(10)->get();

            $specialSuggestions = Landowner::whereNull('business_id')->where('city_id' , $business->city_id)->where('area' , $business->area)
                ->where('type_sale', 'rahn')->whereDoesntHave('dontSuggestedCustomer', function ($query) use ($customerId) {
                    $query->where('customer_id', $customerId)->where('suggest_business' , 1);
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

        return view('customer.suggestion' , compact('suggestions' , 'customer'));
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

        return redirect()->back()->with('message' , 'پیامی برای تایید مشتری ارسال شد.');
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
                $price = $landowner->rahn_amount.'/'.$landowner->rent_amount;
            else
                $price = $landowner->selling_price;
            $smsApi = new SmsAPI();
            $smsApi->sendSmsShareFile($customer->number , $customer->name ,$landowner->scale , $price , $customer->business->number);
            return redirect()->back()->with('message' , 'پیام پیشنهاد شما برای مشتری ارسال شد.');
        }
        else
        {
            return redirect()->back()->with('message' , 'شما قابلیت ارسال پیام ندارید.');
        }
    }
}
