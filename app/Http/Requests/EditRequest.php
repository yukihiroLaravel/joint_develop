<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;                //追加
class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
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
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($this->id)],
            'password' => ['required','string','min:8','confirmed'],
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'ユーザ名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'password_confirmation' => 'パスワードの確認',
        ];
    }
    public function messages() 
    {
        return [
            'name.required' => '名前は、必ず指定してください。',
            'email.required' => ':attribute は、必ず指定してください。',
            'email.unique:users' => ':attribute がすでに使われています。',
            'password.required' => ':attribute は、必ず指定してください。',
            'password.min:8' => ':attribute は、8文字以上にしてください。',    
            'password.confirmed' => 'パスワードとパスワード確認が一致しません。',    

        ];
    }
}
