<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'email' => ['required','string','email','unique:users','max:255'],
            'password' => ['required','string','min:5','confirmed'],
            'password_confirmation' => ['required'],
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
            'name.required' => ':attribute の入力をお願いします',
            'email.required' => ':attribute の入力をお願いします',
            'email.unique:users' => ':attribute がすでに使われています',
            'password.required' => ':attribute の入力をお願いします',
            'password.confirmed' => ':attribute が一致しません',    
        ];
    }



    // public $redirect = "/Requests/EditRequest/";
}
