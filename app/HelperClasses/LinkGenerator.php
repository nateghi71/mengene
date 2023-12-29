<?php

namespace App\HelperClasses;

use App\Models\Customer;
use App\Models\Landowner;
use App\Models\RandomLink;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LinkGenerator
{
    public function generateLinkForCustomer(Customer $customer , $type , $suggest_id = null)
    {
        $randomString = Str::random(15);
        $expirationTime = Carbon::now()->addDays(7);

        $randomLink = $customer->links()->create([
            'guest_number' => $customer->number,
            'expires_at' => $expirationTime,
            'token' => $randomString,
            'type' => $type,
            'number_try' => 0,
            'suggest_id' => $suggest_id
        ]);

        return $randomLink;
    }
    public function updateLink(RandomLink $link)
    {
        $randomString = Str::random(15);
        $expirationTime = Carbon::now()->addDays(7);
        $link->increment('number_try');

        $link->update([
            'expires_at' => $expirationTime,
            'token' => $randomString,
        ]);

        return $link;
    }
    public function generateLinkForLandowner(Landowner $landowner , $type , $suggest_id = null)
    {
        $randomString = Str::random(12);
        $expirationTime = Carbon::now()->addDays(7);

        $randomLink = $landowner->links()->create([
            'guest_number' => $landowner->number,
            'expires_at' => $expirationTime,
            'token' => $randomString,
            'type' => $type,
            'number_try' => 0,
            'suggest_id' => $suggest_id
        ]);

        return $randomLink;
    }

}
