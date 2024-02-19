<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type_file' => 'exclude_if:type_file,business|required',
            'status' => 'exclude_if:type_file,business|required',
            'price' => 'exclude_if:type_file,business,subscription,public,people|required|numeric|between:1000,99999999',

            'type_sale' => 'required',
            'access_level' => 'exclude_if:type_file,buy,subscription,public,people|required',
            'name' => 'required',
            'number' => 'required|iran_mobile',
            'scale' => 'required|numeric',
            'city_id' => 'required|numeric',
            'area' => 'required|numeric',
            'expire_date' => 'required',
            'selling_price' => 'exclude_if:type_sale,rahn|required|numeric',
            'rahn_amount' => 'exclude_if:type_sale,buy|required|numeric',
            'rent_amount' => 'exclude_if:type_sale,buy|required|numeric',
            'type_work' => 'required',
            'type_build' => 'required',
            'document' => 'exclude_if:type_sale,rahn|required',
            'address' => 'required',
            //more
            'year_of_construction' => 'exclude_if:type_build,land,parking,store,hall|nullable|numeric',
            'year_of_reconstruction' => 'exclude_if:type_build,land,parking,store,hall|nullable|numeric',
            'number_of_rooms' => 'exclude_if:type_build,land,parking,store,hall,shop|nullable|numeric',
            'floor_number' => 'exclude_if:type_build,house,land,parking,store,hall,shop|nullable|numeric',
            'floor' => 'exclude_if:type_build,land,parking,store,hall,shop|nullable|numeric',
            'floor_covering' => 'nullable',
            'cooling' => 'nullable',
            'heating' => 'nullable',
            'cabinets' => 'nullable',
            'view' => 'nullable',
            'number_of_unit_in_floor' => 'exclude_if:type_build,land,parking,store,hall,shop|nullable|numeric',
            'number_unit' => 'exclude_if:type_build,land,parking,store,hall,shop|nullable|numeric',
            'postal_code' => 'exclude_if:type_build,land,parking,store,hall,shop|nullable|numeric',
            'plaque' => 'exclude_if:type_build,land,parking,store,hall,shop|nullable|numeric',
            'state_of_electricity' => 'nullable',
            'state_of_water' => 'nullable',
            'state_of_gas' => 'nullable',
            'state_of_phone' => 'nullable',
            'Direction_of_building' => 'nullable',
            'water_heater' => 'nullable',
            'description' => 'nullable',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            'discharge' => 'nullable',
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'is_star' => 'nullable',
            'exist_owner' => 'nullable',
            'terrace' => 'nullable',
            'air_conditioning_system' => 'nullable',
            'yard' => 'nullable',
            'pool' => 'nullable',
            'sauna' => 'nullable',
            'Jacuzzi' => 'nullable',
            'video_iphone' => 'nullable',
            'Underground' => 'nullable',
            'Wall_closet' => 'nullable',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'number' => to_english_numbers($this->input('number')),
            'area' => to_english_numbers($this->input('area')),
            'scale' => to_english_numbers(str_replace( ',', '', $this->input('scale'))),
            'selling_price' => $this->has('selling_price') ? to_english_numbers(str_replace( ',', '', $this->input('selling_price'))) : 0,
            'rahn_amount' => $this->has('rahn_amount') ? to_english_numbers(str_replace( ',', '', $this->input('rahn_amount'))) : 0,
            'rent_amount' => $this->has('rent_amount') ? to_english_numbers(str_replace( ',', '', $this->input('rent_amount'))) : 0,
            'document' => $this->has('document') ? $this->input('document') : 'six_dongs',
            'year_of_construction' => $this->has('year_of_construction') ? to_english_numbers($this->input('year_of_construction')) : null,
            'year_of_reconstruction' => $this->has('year_of_reconstruction') ? to_english_numbers($this->input('year_of_reconstruction')) : null,
            'number_of_rooms' => $this->has('number_of_rooms') ? to_english_numbers($this->input('number_of_rooms')) : null,
            'floor_number' => $this->has('floor_number') ? to_english_numbers($this->input('floor_number')) : null,
            'floor' => $this->has('floor') ? to_english_numbers($this->input('floor')) : null,
            'floor_covering' => $this->has('floor_covering') ? $this->input('floor_covering') : 'null',
            'cooling' => $this->has('cooling') ? $this->input('cooling') : 'null',
            'heating' => $this->has('heating') ? $this->input('heating') : 'null',
            'cabinets'=> $this->has('cabinets') ? $this->input('cabinets') : 'null',
            'view' => $this->has('view') ? $this->input('view') : 'null',
            'number_of_unit_in_floor' => $this->has('number_of_unit_in_floor') ? to_english_numbers($this->input('number_of_unit_in_floor')) : null,
            'number_unit' => $this->has('number_unit') ? to_english_numbers($this->input('number_unit')) : null,
            'postal_code' => $this->has('postal_code') ? to_english_numbers($this->input('postal_code')) : null,
            'plaque' => $this->has('plaque') ? to_english_numbers($this->input('plaque')) : null,
            'state_of_electricity' => $this->has('state_of_electricity') ? $this->input('state_of_electricity') : 'null',
            'state_of_water' => $this->has('state_of_water') ? $this->input('state_of_water') : 'null',
            'state_of_gas' => $this->has('state_of_gas') ? $this->input('state_of_gas') : 'null',
            'state_of_phone' => $this->has('state_of_phone') ? $this->input('state_of_phone') : 'null',
            'Direction_of_building' => $this->has('Direction_of_building') ? $this->input('Direction_of_building') : 'null',
            'water_heater' => $this->has('water_heater') ? $this->input('water_heater') : 'null',
        ]);
    }
}
