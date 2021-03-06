<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ManagerUpdateRequest extends FormRequest {

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
            'name'       => 'required|max:255|string',
            'email'      => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->hidden_id)],
            'restaurant' => 'required',

        ];
    }
    public function messages() {
        return [
            'name.required'       => 'Name is required.',
            'email.required'      => 'Email is required',
            'restaurant.required' => 'Please select a restaurant',
        ];
    }
}
