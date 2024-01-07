<?php

namespace App\HelperClasses;

use App\Models\Premium;
use Carbon\Carbon;

class CheckPremiumExpireDate
{
    public static function checkExpireDate()
    {
        $premiums = Premium::where('expire_date', '<', Carbon::now())->whereNot('level', 'free')->get();
        foreach($premiums as $premium)
        {
            $premium->update([
                'level' => 'free',
                'expire_date' => Carbon::now()->addDecade(),
            ]);
        }
    }
}
