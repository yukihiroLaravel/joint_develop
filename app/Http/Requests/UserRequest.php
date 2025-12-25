<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => ['required','string','min:2','max:255'],
            'email' => ['required','string','email','max:256','unique:users,email'],
            'password'=> ['required', 'min:4','max:256','confirmed'],
        ];
    }
    //※以下日本語編集
    public function messages()
    {
        return [
            'name.required' => '管理者を入力して下さい。',
            'name.min' => ':attributeは:min文字以上で入力して下さい。',
            'name.max' => ':attributeは:max文字以下で入力して下さい。',
            'username.required' => 'ログインIDを入力して下さい。',
            'username.min' => ':attributeは:min文字以上で入力して下さい。',
            'username.max' => ':attributeは:max文字以下で入力して下さい。',
            'password.required' => 'パスワードを入力して下さい。',
            'password.min' => ':attributeは:min文字以上で入力して下さい。',
            'password.max' => ':attributeは:max文字以下で入力して下さい。',
            'password.confirmed' => '確認用パスワードと一致していません。',
        ];
    }

    public function attributes(): array
    {
        return[
        
            'name'=> '管理者名',
            'username' => 'ログインID',
            'password' => 'パスワード',
        
        ];

    }
}
