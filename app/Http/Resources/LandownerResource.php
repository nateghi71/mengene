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
            'name' => $this->name,
            'number' => $this->number,
            'city_id' => $this->city_id,
            'status' => $this->status,
            'type_sale' => $this->type_sale,
            'type_work' => $this->type_work,
            'type_build' => $this->type_build,
            'scale' => $this->scale,
            'number_of_rooms' => $this->number_of_rooms,
            'description' => $this->description,
            'rahn_amount' =>  $this->rahn_amount,
            'rent_amount' =>  $this->rent_amount,
            'selling_price' => $this->selling_price,
            'elevator' => $this->elevator,
            'parking' => $this->parking,
            'store' => $this->store,
            'floor' => $this->floor,
            'floor_number' => $this->floor_number,
            'is_star' => $this->is_star,
            'expire_date' => $this->expire_date
        ];

    }
}
