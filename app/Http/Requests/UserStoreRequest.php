<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest {
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
        $user = User::find($this->users);
        return [
            'name'          => 'required|max:50',
            'email'         => 'required|max:50|email',
            'contact'       => 'required|max:50',
            'password'      => 'required|string|min:6|confirmed',
            'profile_image' => 'nullable|max:600|mimes:jpg,png,jpeg',
        ];
    }
    public function messages() {
        return [
            'name.required'            => 'Name is required.',
            'email.required'           => 'Email is required',
            'contact.required'         => 'Contact is required',
            'password.required'        => 'Contact is required',
            'profile_image.required'   => 'Please upload your photo',
            'profile_image.max'        => 'Maximum file size is 600KB',
            // 'profile_image.dimensions' => 'Photo hight & width should be 200px',
        ];
    }
}
