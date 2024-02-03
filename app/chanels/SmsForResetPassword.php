<?php

namespace App\chanels;

use App\HelperClasses\SmsAPI;
use Illuminate\Notifications\Notification;

class SmsForResetPassword
{
    public function send($notifiable , Notification $notification)
    {
        $link = $notification->toSms($notifiable);
        $smsApi = new SmsAPI();
        $smsApi->sendSmsResetPassword($notifiable->number , $link);
    }
}
