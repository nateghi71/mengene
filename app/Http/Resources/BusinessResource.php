<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'en_name' => $this->en_name,
            'owner_id' => $this->owner_id,
            'user_id' => $this->user_id,
            'city' => $this->city,
            'area' => $this->area,
            'image' => $this->image,
            'address' => $this->address,
            'is_accepted' => $this->is_accepted,
            // Include any other properties you want to expose
        ];
    }
}
