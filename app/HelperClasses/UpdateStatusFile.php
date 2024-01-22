<?php

namespace App\HelperClasses;

use App\Models\Business;
use App\Models\Customer;
use App\Models\Landowner;
use App\Models\RandomLink;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateStatusFile
{
    public static function updateStatusCustomers()
    {
        $customers = Customer::where('expire_date', '<', Carbon::now())->get();

        foreach ($customers as $customer) {
            if($customer->getRawOriginal('status') === 'active')
            {
                $customer->update([
                    'status' =>'unknown'
                ]);

                $link = new LinkGenerator();
                $link = $link->generateLinkForCustomer($customer  , 'expired' , 7);
                $link = route('confirmation.confirmPage' ,
                    ['type' => $link->type , 'token' => $link->token]);

                $smsApi = new SmsAPI();
                $smsApi->sendSmsLink($customer->number ,$customer->name , $link);
            }
            elseif($customer->getRawOriginal('status') === 'unknown')
            {
                $link = RandomLink::where('type', 'expired')->where('linkable_type' , Customer::class)->
                where('linkable_id', $customer->id)->where('expires_at' , '<' , Carbon::now())->first();
                if ($link && $link->number_try < 3)
                {
                    $updatedLink = new LinkGenerator();
                    $updatedLink = $updatedLink->updateLink($link , 7);
                    $updatedLink = route('confirmation.confirmPage' ,
                        ['type' => $updatedLink->type , 'token' => $updatedLink->token]);

                    $smsApi = new SmsAPI();
                    $smsApi->sendSmsLink($customer->number ,$customer->name , $updatedLink);
                }
                else if($link)
                {
                    $customer->update([
                        'status' => 'deActive'
                    ]);
                    $link->delete();
                }
            }
        }
    }

    public static function updateStatusLandowner()
    {
        $landowners = Landowner::where('expire_date', '<', Carbon::now())->get();

        foreach ($landowners as $landowner) {
            if($landowner->getRawOriginal('status') == 'active')
            {

                $landowner->update([
                    'status' =>'unknown'
                ]);

                $link = new LinkGenerator();
                $link = $link->generateLinkForLandowner($landowner , 'expired', 7);
                $link = route('confirmation.confirmPage' ,
                    ['type' => $link->type , 'token' => $link->token]);

                $smsApi = new SmsAPI();
                $smsApi->sendSmsLink($landowner->number ,$landowner->name , $link);
            }
            elseif($landowner->getRawOriginal('status') == 'unknown')
            {
                $link = RandomLink::where('type', 'expired')->where('linkable_type' , Landowner::class)
                    ->where('linkable_id', $landowner->id)->where('expires_at' , '<' , Carbon::now())->first();
                if ($link && $link->number_try < 3)
                {
                    $updatedLink = new LinkGenerator();
                    $updatedLink = $updatedLink->updateLink($link, 7);
                    $updatedLink = route('confirmation.confirmPage' ,
                        ['type' => $updatedLink->type , 'token' => $updatedLink->token]);

                    $smsApi = new SmsAPI();
                    $smsApi->sendSmsLink($landowner->number ,$landowner->name , $updatedLink);
                }
                else if($link)
                {
                    $landowner->update([
                        'status' => 'deActive'
                    ]);
                    $link->delete();
                }
            }

        }
    }

}
