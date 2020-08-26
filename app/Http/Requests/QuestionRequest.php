<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use function Ramsey\Uuid\v1;

class QuestionRequest extends FormRequest
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
            'optionA' => [
                'required',
                'min:2',
                'max:255'
            ],
            'optionB' => [
                'required',
                'min:2',
                'max:255'
            ],
            'optionC' => [
                'required',
                'min:2',
                'max:255'
            ],
            'optionD' => [
                'required',
                'min:2',
                'max:255'
            ]
        ];
    }

    public function messages() 
    {
        return [
            'name.required' => trans('messages.question.validate.name.required'),
            'name.min' => trans('messages.question.validate.name.min'),
            'name.max' => trans('messages.question.validate.name.max'),
            'optionA.required' => trans('messages.question.validate.optionA.required'),
            'optionA.min' => trans('messages.question.validate.optionA.min'),
            'optionA.max' => trans('messages.question.validate.optionA.max'),
            'optionB.required' => trans('messages.question.validate.optionB.required'),
            'optionB.min' => trans('messages.question.validate.optionB.min'),
            'optionB.max' => trans('messages.question.validate.optionB.max'),
            'optionC.required' => trans('messages.question.validate.optionC.required'),
            'optionC.min' => trans('messages.question.validate.optionC.min'),
            'optionC.max' => trans('messages.question.validate.optionC.max'),
            'optionD.required' => trans('messages.question.validate.optionD.required'),
            'optionD.min' => trans('messages.question.validate.optionD.min'),
            'optionD.max' => trans('messages.question.validate.optionD.max'),
        ];
    }
}
