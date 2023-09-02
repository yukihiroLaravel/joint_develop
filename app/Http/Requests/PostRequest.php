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
            'date' => 'required|max:255',
            'postcontent' => 'max:255',
        ];
    }

    public function attributes()
    {
        return [
            'date' => '日付',
            'postcontent' => '投稿内容',
        ];
    }
}
