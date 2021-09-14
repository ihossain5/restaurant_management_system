<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsUpdateRequest extends FormRequest {
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
            'contact' => 'required|max:255|string',
            'email'   => 'required|email|max:100|string',
        ];
    }
    public function messages() {
        return [
            'contact.required' => 'Contact is required.',
            'email.required'   => 'Email is required',
        ];
    }
}
