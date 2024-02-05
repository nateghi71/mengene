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
        return false;
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
            'selling_price' => 'exclude_if:type_sale,rahn|required',
            'rahn_amount' => 'exclude_if:type_sale,buy|required',
            'rent_amount' => 'exclude_if:type_sale,buy|required',
            'type_work' => 'required',
            'type_build' => 'required',
            'document' => 'exclude_if:type_sale,rahn|required',
            'address' => 'required',
            'discharge' => 'nullable',
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'is_star' => 'nullable',
            'exist_owner' => 'nullable',
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
            'description' => 'nullable',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'number' => to_english_numbers($this->input('number')),
            'area' => to_english_numbers($this->input('area')),
            'scale' => to_english_numbers(str_replace( ',', '', $this->input('scale'))),
            'selling_price' => to_english_numbers(str_replace( ',', '', $this->input('selling_price'))),
            'rahn_amount' => to_english_numbers(str_replace( ',', '', $this->input('selling_price'))),
            'rent_amount' => to_english_numbers(str_replace( ',', '', $this->input('selling_price'))),
            'year_of_construction' => to_english_numbers($this->input('year_of_construction')),
            'year_of_reconstruction' => to_english_numbers($this->input('year_of_reconstruction')),
            'number_of_rooms' => to_english_numbers($this->input('number_of_rooms')),
            'floor_number' => to_english_numbers($this->input('floor_number')),
            'floor' => to_english_numbers($this->input('floor')),
        ]);
    }

}
