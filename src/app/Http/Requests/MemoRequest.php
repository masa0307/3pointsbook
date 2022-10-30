<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemoRequest extends FormRequest
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
            'before_reading_content' => ['string', 'max:250'],
            'reading_content' => ['nullable', 'string', 'max:250'],
            'after_reading_content' => ['nullable', 'string', 'max:250'],
            'actionlist1_content' => ['string', 'max:250'],
            'actionlist2_content' => ['nullable', 'string', 'max:250'],
            'actionlist3_content' => ['nullable', 'string', 'max:250'],
            'feedback1_content' => ['string', 'max:250'],
            'feedback2_content' => ['nullable', 'string', 'max:250'],
            'feedback3_content' => ['nullable', 'string', 'max:250'],
        ];
    }
}
