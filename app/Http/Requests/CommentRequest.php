<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'comment.' . $this->post_id => 'required_without_all:img_path|max:140',
            'img_path.' . $this->post_id => 'max:1024|image|mimes:jpg,jpeg,png,gif',
        ];
    }

    public function messages()
    {
        return [
            'comment.*.required_without_all' => 'コメントもしくは画像のいずれかの投稿は必須です',
            'comment.*.max' => 'コメントは140文字以下で入力して下さい',
        ];
    }
}
