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
            'en_name' => $this->en_name,
            'image' => $this->image,
            'city' => $this->city,
            'area' => $this->area,
            'address' => $this->address,
            'user_id' => $this->user_id,
        ];
    }
}
