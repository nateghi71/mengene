<?php

namespace App\Listeners;

use App\Events\CreateLandownerFile;
use App\HelperClasses\SmsAPI;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSmsToLandowner
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CreateLandownerFile $event): void
    {
        if($event->user->isVipUser() || ($event->user->isMidLevelUser() && $event->user->getPremiumCountSms() <= 1000))
        {
            $event->user->incrementPremiumCountSms();
            $smsApi = new SmsAPI();
            $smsApi->sendSmsRegisterFile($event->landowner->number , $event->landowner->name , $event->user->business()->name , $event->user->business()->number);
        }
    }
}
