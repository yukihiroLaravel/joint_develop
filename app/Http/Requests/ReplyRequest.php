<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return true
     */
    public function rules()
    {
        return [
            'reply' => 'max:50'
        ];
    }

    public function attributes()
    {
        return [
            'reply' => '返信',           
        ];
    }
}
