<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->any()) {
                if(is_null(session('search_number'))){
                    //ユーザーの検索回数をセット
                    session()->put(['search_number' => 0]);
                }

                session()->put(['search_number' => session('search_number')+1]);
                session()->forget('search_number_limit');

                if(session('search_number') === 2){
                    session()->put(['search_number_limit' => '※あと1回間違えるとログアウトします']);
                }

                if(session('search_number') == 3){
                    session()->put(['search_number' => 0]);
                    Auth::logout();
                }
           }else{
                //該当ユーザーが存在した場合は、検索回数をリセット
                session()->forget('search_number');
           }
        });
    }

}
