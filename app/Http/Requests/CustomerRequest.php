<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'discharge' => 'nullable',
            'elevator' => 'nullable',
            'parking' => 'nullable',
            'store' => 'nullable',
            'is_star' => 'nullable',
            'exist_owner' => 'nullable',
            //more
            'year_of_construction' => 'nullable|numeric',
            'year_of_reconstruction' => 'nullable|numeric',
            'number_of_rooms' => 'nullable|numeric',
            'floor_number' => 'exclude_if:type_build,house|exclude_if:type_build,land|nullable|numeric',
            'floor' => 'exclude_if:type_build,land|nullable|numeric',
            'floor_covering' => 'nullable',
            'cooling' => 'nullable',
            'heating' => 'nullable',
            'cabinets' => 'nullable',
            'view' => 'nullable',
            'description' => 'nullable',
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
