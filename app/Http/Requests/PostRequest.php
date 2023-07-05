<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'text' => 'required_without_all:img_path|max:140',
            'img_path' => 'max:1024|image|mimes:jpg,jpeg,png,gif',
        ];
    }

    public function attributes()
    {
        return [
            'text' => '投稿',
            'img_path' => '画像',
        ];
    }

    public function messages()
    {
        return [
            'text.required_without_all' => 'テキストもしくは画像のいずれかの投稿は必須です',
        ];
    }
}
