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
            'content' => 'required|max:140',
            'tag_ids.*'    => 'exists:tags,id',
            'new_tags'     => 'nullable|string|max:50',
        ];
    }

    public function attributes()
    {
        return [
            'content' => '投稿内容',
        ];
    }
}
