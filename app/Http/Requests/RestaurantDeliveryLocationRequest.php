<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantDeliveryLocationRequest extends FormRequest {
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
            'delivery_fee' => 'required|max:255|string',
            'location_id'     => 'required|max:10',
            'restaurant_id'   => 'required|max:10',
        ];
    }
    public function messages() {
        return [
            'delivery_fee.required' => 'Please insert delivery fee.',
            'location.required'     => 'Please select a location.',
            'restaurant.required'   => 'Please select a restaurant.',
        ];
    }
}
