<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerSignInRequest extends FormRequest {
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
            'email'    => 'required|email|max:100|string',
            'password' => 'required|string|max:100|min:6',
        ];
    }
    public function messages() {
        return [
            'email.required'    => 'Email is required',
            'password.required' => 'Password is required',
        ];
    }
}
