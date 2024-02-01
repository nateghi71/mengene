<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'name' => $this->name,
            'image' => $this->image,
            'city_id' => $this->city_id,
            'area' => $this->area,
            'address' => $this->address,
            'user_id' => $this->user_id,
            "added" => $this->customers_count + $this->landowners_count,
        ];
    }
}
