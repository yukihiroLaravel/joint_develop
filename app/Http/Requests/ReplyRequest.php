<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class ReplyRequest extends FormRequest
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
        ];
    }

    // バリデーション失敗時に 'reply_{postId}' エラーバッグを使用
    protected function failedValidation(Validator $validator)
    {
        $postId = $this->route('id'); // ルートパラメータから投稿IDを取得
        throw (new ValidationException($validator))
            ->errorBag('reply_' . $postId);
    }

    public function attributes()
    {
        return [
            'content' => '返信',
        ];
    }
}
