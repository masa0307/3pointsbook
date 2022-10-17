<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupUserRequest extends FormRequest
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
            'user_id' => Rule::unique('group_users')->where(function($query) {
                $query->where('group_id', session('group')->id);
            }),
            'name' => 'exists:users',
        ];
    }

    public function messages()
    {
        return [
            'user_id.unique' => 'このユーザーは既に追加されています。',
            'name.exists' => '該当するユーザーがいません'
        ];
    }

}
