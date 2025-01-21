<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //false to true
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickname' => 'required|string|max:25|unique:users,nickname,' . auth()->id(),
            'email' => 'required|string|max:30|email|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:8|max:12|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])[A-Za-z\d@$!%*?&]+$/',
        ];
    }

    public function attribute()
    {
        return [
            'nickname' => 'ニックネーム',
            'email' => 'Eメールアドレス',
            'password' => 'パスワード'
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'パスワードは大文字、小文字を最小一つ含む必要があります。',
        ];
    }
    
}
