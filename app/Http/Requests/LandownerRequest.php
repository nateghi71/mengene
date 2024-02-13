<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LandownerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type_sale' => 'required',
            'access_level' => 'required',
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
            'year_of_construction' => 'nullable',
            'year_of_reconstruction' => 'nullable',
            'number_of_rooms' => 'nullable|numeric',
            'floor_number' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
            'floor' => 'exclude_if:type_build,land|nullable|numeric',
            'floor_covering' => 'nullable',
            'cooling' => 'nullable',
            'heating' => 'nullable',
            'cabinets' => 'nullable',
            'view' => 'nullable',
            'number_of_unit_in_floor' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
            'number_unit' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
            'postal_code' => 'nullable|numeric',
            'plaque' => 'nullable|numeric',
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
            'selling_price' => ($this->input('selling_price') !== null) ? to_english_numbers(str_replace( ',', '', $this->input('selling_price'))) : $this->input('selling_price'),
            'rahn_amount' => ($this->input('rahn_amount') !== null) ? to_english_numbers(str_replace( ',', '', $this->input('rahn_amount'))) : $this->input('rahn_amount'),
            'rent_amount' => ($this->input('rent_amount') !== null) ? to_english_numbers(str_replace( ',', '', $this->input('rent_amount'))) : $this->input('rent_amount'),
            'year_of_construction' => ($this->input('year_of_construction') !== null) ? to_english_numbers($this->input('year_of_construction')) : $this->input('year_of_construction'),
            'year_of_reconstruction' => ($this->input('year_of_reconstruction') !== null) ? to_english_numbers($this->input('year_of_reconstruction')) : $this->input('year_of_reconstruction'),
            'number_of_rooms' => ($this->input('number_of_rooms') !== null) ? to_english_numbers($this->input('number_of_rooms')) : $this->input('number_of_rooms'),
            'floor_number' => ($this->input('floor_number') !== null) ? to_english_numbers($this->input('floor_number')) : $this->input('floor_number'),
            'floor' => ($this->input('floor') !== null) ? to_english_numbers($this->input('floor')) : $this->input('floor'),
        ]);
    }
}
