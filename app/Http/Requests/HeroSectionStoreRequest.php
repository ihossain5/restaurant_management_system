<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroSectionStoreRequest extends FormRequest {
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
            'heading'     => 'required|max:255|string',
            'description' => 'required|max:10000|string',
            'pic'         => 'required|max:2000|image|mimes:png,jpg,jpeg|dimensions:min_width=1920,min_height=1080',
        ];
    }
    public function messages() {
        return [
            'heading.required'     => 'Heading is required.',
            'description.required' => 'Description is required',
            'pic.required'         => 'Photo is required',
            'pic.dimensions'       => 'Photo min width should be 1920 and min height should be 1080 pixel',
            // 'pic.max'              => 'Photo min width should be 1920 and min height should be 1080 pixel',
        ];
    }
}
