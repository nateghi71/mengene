<?php

namespace App\chanels;

use App\HelperClasses\SmsAPI;
use Illuminate\Notifications\Notification;

class SmsToConsultant
{
    public function send($notifiable , Notification $notification)
    {
        $consultantName = $notification->toSms($notifiable);

        $smsApi = new SmsAPI();
        $smsApi->sendSmsConsultantRequest($notifiable->number , $notifiable->name, $consultantName);
    }
}
