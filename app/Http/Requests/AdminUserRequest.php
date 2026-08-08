<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $emailRule = 'unique:users,email';

        if ($this->isMethod('put')) {
            $emailRule .= ',' . $this->route('id');
        }

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|' . $emailRule,
            'password' => $this->isMethod('post')
                ? 'required|string|min:8|confirmed'
                : 'nullable|string|min:8|confirmed',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'ユーザー名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }
}