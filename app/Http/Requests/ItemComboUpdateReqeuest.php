<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemComboUpdateReqeuest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name'   => 'required|max:255|string',
            'price'  => 'required|numeric',
            'item'   => 'required|array',
            "item.*" => "required|string|distinct",
            'photo'  => 'nullable|max:600|image|mimes:png,jpg,jpeg',
        ];
    }
    public function messages() {
        return [
            'name.required'  => 'Name is required.',
            'price.required' => 'Price is required',
            'item.required'  => 'Item is required',
        ];
    }
}
