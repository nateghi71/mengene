<?php

namespace App\Listeners;

use App\Events\CreateCustomerFile;
use App\HelperClasses\SmsAPI;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSmsToCustomer
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
    public function handle(CreateCustomerFile $event): void
    {
        if($event->user->isVipUser() || ($event->user->isMidLevelUser() && $event->user->getPremiumCountSms() <= 1000))
        {
            $event->user->incrementPremiumCountSms();
            $smsApi = new SmsAPI();
            $smsApi->sendSmsRegisterFile($event->customer->number , $event->customer->name , $event->user->business()->name , $event->user->business()->number);
        }
    }
}
