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
    public function authorize() //このフォームリクエストを使うか否かを表す
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() //rules()配列の形でリターンさせる決まりがある
    {
        return [
            'content' => 'required|max:140',  //投稿内容は140文字以内とする
        ];
    }
}
