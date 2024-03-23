<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserIconRequest extends FormRequest
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
            'icon' => 'image |mimes:png,jpg,jpeg|max:1024'
        ];
    }
    /**
     * バリデーションエラーメッセージ
     *
     * @return array
     */
    public function messages()
    {
        return [
            'icon.max' => 'ファイルサイズが大きすぎます。ファイルサイズは1MB以内にしてください。',
            'icon.mimes' => '指定のファイル形式以外は添付できません。',
        ];
    }
}
