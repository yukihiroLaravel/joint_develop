<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

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
            'content' => 'nullable|max:140',
            'images.*' => 'image|max:5000',
            'tags'     => 'nullable|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // 投稿も画像も空の場合はエラー
            if (!$this->filled('content') && !$this->hasFile('images')) {
                $validator->errors()->add('content', '投稿内容か画像のどちらかを入力してください。');
            }

            // タグのバリデーション
            if ($this->filled('tags')) {
                $tags = collect(explode(',', $this->input('tags')))
                    ->map(fn($tag) => trim($tag))
                    ->filter();
                // タグの数制限
                if ($tags->count() > 5) { // 例: 最大5つ
                    $validator->errors()->add('tags', 'タグは最大5つまで登録できます。');
                }
                // タグの文字数制限
                foreach ($tags as $tag) {
                    if (mb_strlen($tag) > 20) { // 例: 20文字以内
                        $validator->errors()->add('tags', "タグ「{$tag}」は20文字以内で入力してください。");
                    }
                }
                // 重複タグのチェック
                if ($tags->count() !== $tags->unique()->count()) {
                    $validator->errors()->add('tags', 'タグに重複があります。');
                }
            }
        });
    }

    // バリデーション失敗時に 'post' エラーバッグを使用
    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))
            ->errorBag('post');
    }

    public function attributes()
    {
        return [
            'content' => '投稿',
            'tags'    => 'タグ',
        ];
    }
}
