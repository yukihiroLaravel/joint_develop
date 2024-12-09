<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

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
    public function rules()
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,'. $this->id],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048']
        ];
    }

    public function messages()
    {
        return [
            'password.confirmed' => 'パスワードが一致しません',
            'avatar.image' => '画像ファイルを選択してください',
            'avatar.max' => '最大2MBまでの画像ファイルを選択してください'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // 失敗したバリデーションルールを確認
        // dd($validator->failed());

        parent::failedValidation($validator); // 通常の処理も確認する場合
    }
}
