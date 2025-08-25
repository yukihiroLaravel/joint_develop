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
            'post_id' => 'required|exists:posts,id',
        ];
    }

    // バリデーション失敗時に、返信フォームごとのエラーバッグを使用
    protected function failedValidation(Validator $validator)
    {
        $postId = $this->input('post_id', 0); // 送信されたpost_idを取得
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
