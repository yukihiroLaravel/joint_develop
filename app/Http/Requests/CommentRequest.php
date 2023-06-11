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
            'comment.' . $this->post_id => 'required|max:40',
        ];
    }

    public function attributes()
    {
        return [
            'comment.' . $this->post_id => 'コメント',
        ];
    }

}
