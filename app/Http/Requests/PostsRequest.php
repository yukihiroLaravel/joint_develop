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
            'user_id' => 'required|max:20',
            'content' => 'required|max:140',
        ];
    }
    public function attributes()
    {
        return [
            'user_id' => 'ユーザーネーム',
            'content' => '投稿',
        ];
    }
}