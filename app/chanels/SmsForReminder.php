<?php

namespace App\chanels;

use App\HelperClasses\SmsAPI;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SmsForReminder
{
    public function send($notifiable , Notification $notification)
    {
        $info_cus = $notification->smsReminder($notifiable);
        $smsApi = new SmsAPI();
        $smsApi->sendSmsReminderForBusiness($notifiable->number , $info_cus['name_cus'], $info_cus['date']);
        $user = auth()->user();
        $user->incrementPremiumCountSms();
        $user->business()->decrement('wallet' , 200);

        $smsApi = new SmsAPI();
        $smsApi->sendSmsReminderForCustomer($info_cus['number_cus'] , $notifiable->name, $info_cus['message'], $info_cus['date']);
        $user->incrementPremiumCountSms();
        $user->business()->decrement('wallet' , 200);

    }
}
