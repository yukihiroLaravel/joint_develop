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
            // 'image' => 'image|max:2048' // 画像ファイルかをチェック、最大2MB
            'image' => 'mimes:jpeg,png,gif,webp,svg|max:2048' // 画像ファイルかをチェック、最大2MB
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
