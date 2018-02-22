<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionsRequest extends FormRequest
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
            'description'                     =>'required',
            'question_type_id'                =>'required',
            'multiple_choice.*.answer_description' =>'required'
        ];
    }

    public function messages(){
        return [
            'description.required' => 'Pertanyaan Harap di Isi',
            'custom'=>[
                'multiple_choice.*.answer_description' => [
                    'required'=>'Jawaban Wajib di isi'
                    ]
                ]
        ];
    }
}
