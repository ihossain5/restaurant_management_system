<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest {
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
            'name'     => 'required|max:255|string',
            'description' => 'required|max:10000|string',
            'restaurant_id' => 'required|max:10000|string',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'name is required.',
            'description.required'  => 'Description is required',
        ];
    }
}
