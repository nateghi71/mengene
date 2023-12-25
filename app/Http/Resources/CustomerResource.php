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
//        if ($this->type_sale == 'buy') {
//            $type_sale = 'فروشی';
//        } else {
//            $type_sale = 'رهن و اجاره';
//        }
//        if ($this->is_star == 0) {
//            $is_star = '';
//        } else {
//            $is_star = '*';
//        }
//        if ($this->status == 'unknow') {
//            $status = 'غیر فعال';
//        } else {
//            $status = 'فعال';
//        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'number' => $this->number,
            'city' => $this->city,
            'description' => $this->description,
            'type_sale' => $this->type_sale,
            'price' => $this->selling_price,
            'rent' => $this->rent_amount,
            'status' => $this->status,
            'star' => $this->is_star,
//            'business_en_name' => $this->business_en_name,
            'expire_date' => $this->expire_date,
//            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];

    }
}
