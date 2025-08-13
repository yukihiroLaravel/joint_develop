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
            'content' => 'nullable|max:140',
            'images.*' => 'image|max:5000',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->content && !$this->hasFile('images.*')) {
                $validator->errors()->add('content', '投稿内容か画像のどちらかを入力してください。');
            }
        });
    }

    public function attributes()
    {
        return [
            'content' => '投稿',
        ];
    }
}
