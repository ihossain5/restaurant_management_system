<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroSectionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'pic'         => 'nullable|max:600|image|mimes:png,jpg',
        ];
    }
    public function messages()
    {
        return [
            'heading.required' => 'Heading is required.',
            'description.required'  => 'Description is required',
        ];
    }
}
