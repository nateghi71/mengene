<?php

namespace App\HelperClasses;

use Ghasedak\GhasedakApi;

class SmsAPI
{
    public function sendSms($number , $param)
    {
        $template = "authVerifyCode";
        $api = new GhasedakApi(env('API_KEY_SMS'));
        $api->Verify($number, $template, $param);
    }
}
