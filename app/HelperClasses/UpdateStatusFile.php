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
            if($customer->status == 'active')
            {
                $customer->update([
                    'status' =>'unknown'
                ]);

                $link = new LinkGenerator();
                $link = $link->generateLinkForCustomer($customer , 'expired');
                $link = route('confirmation.confirmPage' ,
                    ['type' => $link->type , 'token' => $link->token]);

                $smsApi = new SmsAPI();
//                $smsApi->sendSms($customer->number , $link);
            }
            elseif($customer->status == 'unknown')
            {
                $link = RandomLink::where('linkable_type' , Customer::class)->where('linkable_id', $customer->id)->
                    where('expires_at' , '<' , Carbon::now())->first();
                if ($link && $link->number_try <= 1)
                {
                    $updatedLink = new LinkGenerator();
                    $updatedLink = $updatedLink->updateLink($link);
                    $updatedLink = route('confirmation.confirmPage' ,
                        ['type' => $updatedLink->type , 'token' => $updatedLink->token]);

                    $smsApi = new SmsAPI();
//                $smsApi->sendSms($customer->number , $updatedLink);

                }
                else
                {
                    $customer->update([
                        'status' => 'deActive'
                    ]);
                    $link->delete();
                    $customer->delete();
                }
            }
        }
    }

    public static function updateStatusLandowner()
    {
        $landowners = Landowner::where('expire_date', '<', Carbon::now())->get();

        foreach ($landowners as $landowner) {
            if($landowner->status == 'active')
            {

                $landowner->update([
                    'status' =>'unknown'
                ]);

                $link = new LinkGenerator();
                $link = $link->generateLinkForLandowner($landowner , 'expired');
                $link = route('confirmation.confirmPage' ,
                    ['type' => $link->type , 'token' => $link->token]);

                $smsApi = new SmsAPI();
//                $smsApi->sendSms($landowner->number , $link);
            }
            elseif($landowner->status == 'unknown')
            {
                $link = RandomLink::where('linkable_type' , Landowner::class)->where('linkable_id', $landowner->id)->
                where('expires_at' , '<' , Carbon::now())->first();
                if ($link && $link->number_try <= 1)
                {
                    $updatedLink = new LinkGenerator();
                    $updatedLink = $updatedLink->updateLink($link);
                    $updatedLink = route('confirmation.confirmPage' ,
                        ['type' => $updatedLink->type , 'token' => $updatedLink->token]);

                    $smsApi = new SmsAPI();
//                $smsApi->sendSms($customer->number , $updatedLink);

                }
                else
                {
                    $landowner->update([
                        'status' => 'deActive'
                    ]);
                    $link->delete();
                    $landowner->delete();
                }
            }

        }
    }

}
