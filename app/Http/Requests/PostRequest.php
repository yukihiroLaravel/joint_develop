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
            'content.*' => 'required|max:140', // 配列形式（返信）に適用
            'content'   => 'required_without:parent_id|max:140', // 親投稿用
            // タグ：親投稿(tags[0])、返信(tags[parent_id])の両方を一括チェック
            // ドット記法で「tags配列の中身すべて」を指定
            'tags'      => 'nullable', 
            'tags.*'    => 'nullable|max:30',
            'favorite_flag' => 'nullable|boolean',
        ];
    }
    
    public function attributes()
    {
        return [
            'content' => '投稿内容',
            'content.*' => '投稿内容',
            'tags' => 'タグ',
            'tags.*' => 'タグ',
            'favorite_flag' => 'いいね！の許可設定',
        ];
    }
}
