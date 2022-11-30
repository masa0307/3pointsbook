<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:50'],
            'title' => Rule::unique('books')->where(function ($query) {
                return $query->where('user_id', Auth::id())->whereIn('books.state', ['読書中', '気になる']);
            }),
            'title_kana' => ['required', 'string', 'max:50'],
            'author' => ['required', 'string', 'max:20'],
        ];
    }
}
