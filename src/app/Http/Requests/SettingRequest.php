<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'name'            => ['string', 'max:20', 'unique:users'],
            'email'           => ['string', 'email', 'max:30', 'unique:users'],
            'genre_name'      => ['string', 'max:20', 'unique:genres'],
            'update_password' => ['string', 'max:30']
        ];
    }
}
