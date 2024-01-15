<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LandownerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'number' => $this->number,
            'city_id' => $this->city_id,
            'status' => $this->getRawOriginal('status'),
            'type_sale' => $this->getRawOriginal('type_sale'),
            'type_work' => $this->getRawOriginal('type_work'),
            'type_build' => $this->getRawOriginal('type_build'),
            'meterage' => $this->getRawOriginal('scale'),
            'rooms' => $this->number_of_rooms,
            'description' => $this->description,
            'rahn' =>  $this->getRawOriginal('rahn_amount'),
            'ejareh' =>  $this->getRawOriginal('rent_amount'),
            'price' => $this->getRawOriginal('selling_price'),
            'elevator' => $this->getRawOriginal('elevator'),
            'parking' => $this->getRawOriginal('parking'),
            'store' => $this->getRawOriginal('store'),
            'floor' => $this->floor,
            'num_floor' => $this->floor_number,
            'is_star' => $this->getRawOriginal('is_star'),
            'expiry_date' => $this->getRawOriginal('expire_date')
        ];

    }
}
