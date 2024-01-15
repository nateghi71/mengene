<?php

namespace App\HelperClasses;

use Ghasedak\GhasedakApi;

class SmsAPI
{
    public function sendSmsCode($number , $param)
    {
        $template = "authVerifyCode";
        $api = new GhasedakApi(env('API_KEY_SMS'));
        $api->Verify($number,  $template, $param);
    }
    public function sendSmsLink($number , $name , $link): void
    {
        $template = "UserVerificationLink";
        $api = new GhasedakApi(env('API_KEY_SMS'));
        $api->Verify($number, $template , $name , $link);
    }
    public function sendSmsConsultantRequest($number , $owner_name, $consultant_name): void
    {
        $template = "ConsultantRequest";
        $api = new GhasedakApi(env('API_KEY_SMS'));
        $api->Verify($number, $template, $owner_name, $consultant_name);
    }
    public function sendSmsRegisterFile($number , $file_name , $business_name , $business_number): void
    {
        $template = "ConfirmRegistration";
        $api = new GhasedakApi(env('API_KEY_SMS'));
        $api->Verify($number, $template, $file_name, $business_name , $business_number);
    }
    public function sendSmsShareFile($number , $file_name , $scale , $price  , $business_number): void
    {
        $template = "ShareFileInfoToCustomer";
        $api = new GhasedakApi(env('API_KEY_SMS'));
        $api->Verify($number, $template, $file_name, $scale , $price , $business_number);
    }
    public function sendSmsReminderForBusiness($number , $business_name , $date): void
    {
        $template = "reminderSmsForBusiness";
        $api = new GhasedakApi(env('API_KEY_SMS'));
        $api->Verify($number, $template, $business_name , $date);
    }
    public function sendSmsReminderForCustomer($number , $business_name , $message , $date): void
    {
        $template = "reminderSmsForCustomer";
        $api = new GhasedakApi(env('API_KEY_SMS'));
        $api->Verify($number, $template, $business_name, $message , $date);
    }
}
