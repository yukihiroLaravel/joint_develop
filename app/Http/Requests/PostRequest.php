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
            'post' => 'max:140',
        ];
    }

    /**
     * 属性値を日本語で返す.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'post' => '投稿',
        ];
    }
}
