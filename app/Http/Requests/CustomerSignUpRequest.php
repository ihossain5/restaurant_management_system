<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerSignUpRequest extends FormRequest {
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
            'email'    => 'required|email|max:100|string|unique:customers,email',
            'contact'  => 'required|min:11|max:14',
            'password' => 'required|string|max:100',
        ];
    }
    public function messages() {
        return [
            'contact.required'  => 'Contact is required.',
            'name.required'     => 'Name is required.',
            'email.required'    => 'Email is required',
            'password.required' => 'Password is required',
        ];
    }
}
