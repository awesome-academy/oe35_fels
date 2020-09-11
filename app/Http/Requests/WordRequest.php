<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WordRequest extends FormRequest
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
                'required',
                'min:2',
                'max:255',
            ],
            'mean' => [
                'max:255',
            ],
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'name.required' => trans('messages.validate.name.required'),
            'name.min' => trans('messages.validate.name.min'),
            'name.max' => trans('messages.validate.name.max'),
            'mean.max' => trans('messages.validate.name.max'),
        ];
    }
}
