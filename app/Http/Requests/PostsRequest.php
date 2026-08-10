<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostsRequest extends FormRequest
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
            'content' => 'required|max:140',
            'image' => 'mimes:jpeg,jpg,png,webp|max:2048', // 画像ファイル形式を指定、最大2MB
            'tags' => 'array|max:3', // タグを投稿する際に0~3個まで選択できる
        ];
    }

    public function messages()
    {
        // 画像ファイル以外が2MB超のとき、汎用メッセージだとわかりにくいため
        return [
            'image.uploaded' => 'アップロードに失敗しました（ファイル形式、サイズを確認してください）。',
        ];
    }
}
