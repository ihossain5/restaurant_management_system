<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest {
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
        // $user = $this->user();
        return [
            'name'        => 'required|max:255|string',
            'email'       => 'required|email|max:255',
            'address'     => 'required',
            'contact'     => 'required|max:255',
            'instruction' => 'nullable|max:255',
            'item'        => 'required|array',
            'item*'       => 'required',

        ];
    }
    public function messages() {
        return [
            'name.required'    => 'Name is required.',
            'email.required'   => 'Email is required',
            'address.required' => 'Please insert address',
            'contact.required' => 'Please insert contact',
            'item.required'    => 'Please add item in your cart',
        ];
    }
}
