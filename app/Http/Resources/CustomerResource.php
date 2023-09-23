<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->type == 'buy') {
            $type = 'فروشی';
        } else {
            $type = 'رهن و اجاره';
        }
        if ($this->is_star == 0) {
            $star = '';
        } else {
            $star = '*';
        }
        if ($this->status == 0) {
            $status = 'غیر فعال';
        } else {
            $status = 'فعال';
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'number' => $this->number,
            'city' => $this->city,
            'address' => $this->address,
            'type' => $type,
            'price' => $this->price,
            'rent' => $this->rent,
            'status' => $status,
            'star' => $star,
            'business_en_name' => $this->business_en_name,
            'expiry_date' => $this->expiry_date,
//            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];

    }
}
