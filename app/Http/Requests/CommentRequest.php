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
    public function rules()
    {
        $postId = $this->route('postId');
        return [
            'comment_' . $postId => 'required|max:140'
        ];
    }

    public function attributes()
    {
        $postId = $this->route('postId');
        return [
            'comment_' . $postId => 'コメント'
        ];
    }


    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
}
