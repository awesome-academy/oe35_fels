<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => [
                'max:255',
            ],
            'email' => [
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'image' => [
                'image',
                'mimes:jpeg,png,jpg,gif,svg,bmp',
                'max:2048',
                'dimensions:max_width=512,max_height=512',
            ],
        ];
    }
}
