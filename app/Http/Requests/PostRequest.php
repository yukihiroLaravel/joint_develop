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
    // このフォームリクエストを使うか否かを表す
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // rules()配列の形でリターンさせる決まりがある
    public function rules()
    {
        return [
            'content' => 'required|max:140', // 投稿内容は140文字以内とする
        ];
    }
}
