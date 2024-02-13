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
            'id' => $this->id,
            'status' => $this->getRawOriginal('status'),
            'type_file' => $this->getRawOriginal('type_file'),
            'type_sale' => $this->getRawOriginal('type_sale'),
            'access_level' => $this->getRawOriginal('access_level'),
            'name' => $this->name,
            'number' => $this->number,
            'meterage' => $this->getRawOriginal('scale'),
            'city_id' => $this->city_id,
            'area' => $this->area,
            'expire_date' => $this->getRawOriginal('expire_date'),
            'rahn' =>  $this->getRawOriginal('rahn_amount'),
            'ejareh' =>  $this->getRawOriginal('rent_amount'),
            'price' => $this->getRawOriginal('selling_price'),
            'type_work' => $this->type_work,
            'type_build' => $this->type_build,
            'document' => $this->document,
            'address' => $this->address,
            'discharge' => $this->getRawOriginal('discharge'),
            'elevator' => $this->getRawOriginal('elevator'),
            'parking' => $this->getRawOriginal('parking'),
            'store' => $this->getRawOriginal('store'),
            'is_star' => $this->getRawOriginal('is_star'),
            'exist_owner' => $this->getRawOriginal('exist_owner'),
            'year_of_construction' => $this->year_of_construction,
            'year_of_reconstruction' => $this->year_of_reconstruction,
            'rooms' => $this->number_of_rooms,
            'floor' => $this->floor,
            'num_floor' => $this->floor_number,
            'floor_covering' => $this->getRawOriginal('floor_covering'),
            'cooling' => $this->getRawOriginal('cooling'),
            'heating' => $this->getRawOriginal('heating'),
            'cabinets' => $this->getRawOriginal('cabinets'),
            'view' => $this->getRawOriginal('view'),
            'description' => $this->description,
            'business_id' => $this->business_id,
            'user_id' => $this->user_id,
        ];

    }
}
