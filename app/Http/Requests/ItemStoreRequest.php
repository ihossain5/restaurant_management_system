<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest {
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
            'name'        => 'required|max:255|string',
            'description' => 'required|max:10000|string',
            'taste'       => 'required',
            'volume'      => 'required|numeric',
            'price'      => 'required|numeric',
            'category_id' => 'required',
            'photo'       => 'required|max:600|image|mimes:png,jpg,jpeg',
        ];
    }
    public function messages() {
        return [
            'name.required'     => 'Name is required.',
            'description.required' => 'Description is required',
        ];
    }
}
