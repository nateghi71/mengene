<?php

namespace App\HelperClasses;

use Ghasedak\GhasedakApi;

class SmsAPI
{
    public function sendSmsCode($number , $param)
    {
        $template = "authVerifyCode";
        $api = new GhasedakApi(env('API_KEY_SMS'));
        $api->Verify($number, $template, $param);
    }
    public function sendSmsLink($number , $param): void
    {
        $template = "authVerifyCode";
        $api = new GhasedakApi(env('API_KEY_SMS'));
        $api->Verify($number, $template, $param);
    }
}
