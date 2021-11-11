<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantStoreRequest extends FormRequest {
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
            'email'       => 'required|email|max:255|string',
            'contact'     => 'required|max:255|string',
            'type'        => 'required|max:255|string',
            'description' => 'required|max:10000|string',
            'address'     => 'required|max:10000|string',
            'logo'        => 'nullable|max:300|image|mimes:png,jpg,jpeg,svg',
            // 'location'   => 'required|array',
            // "location.*" => "required|string|distinct",
        ];
    }
    public function messages() {
        return [
            'name.required'        => 'Name is required.',
            'email.required'       => 'Email is required',
            'contact.required'     => 'Contact is required',
            'type.required'        => 'Type is required',
            'description.required' => 'Description is required',
            'address.required'     => 'Address is required',
            'logo.required'        => 'Logo is required',
        ];
    }
}
