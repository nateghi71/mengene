<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return
        [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "number" => $this->number,
            "city" => $this->city->name,
            "added" => $this->customers_count + $this->landowners_count,
        ];
    }
}
