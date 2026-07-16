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
            'content' => 'required|string|max:140',
            'tags' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    $tags = $this->normalizeTags($value);

                    if (count($tags) > 3) {
                        $fail('タグは3個以内で入力してください。');

                        return;
                    }

                    foreach ($tags as $tag) {
                        if (mb_strlen($tag) > 20) {
                            $fail('タグは1個につき20文字以内で入力してください。');

                            return;
                        }
                    }
                },
            ],
        ];
    }

    // バリデーション項目の表示名を定義
    public function attributes()
    {
        return [
            'content' => '投稿',
            'tags' => 'タグ',
        ];
    }

    // 整形済みのタグ名一覧を取得
    public function tagNames()
    {
        return $this->normalizeTags($this->input('tags'));
    }

    // カンマ区切りのタグ入力を整形
    private function normalizeTags($value)
    {
        // 入力された文字列をカンマで分割
        $tags = explode(',', (string) $value);

        // 配列をCollectionに変換
        $tags = collect($tags);

        // 各タグの前後の半角・全角スペースと、先頭の#を除去
        $tags = $tags->map(function ($tag) {
            $tag = preg_replace('/^[\s　]+|[\s　]+$/u', '', $tag);
            $tag = ltrim($tag, '#');

            return preg_replace('/^[\s　]+|[\s　]+$/u', '', $tag);
        });

        // 空のタグを除去
        $tags = $tags->filter(function ($tag) {
            return $tag !== '';
        });

        // 重複するタグを除去
        $tags = $tags->unique();

        // 配列番号を0から振り直し
        $tags = $tags->values();

        // Collectionを通常の配列に変換して返す
        return $tags->all();
    }
}
