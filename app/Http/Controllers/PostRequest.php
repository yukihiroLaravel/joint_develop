<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostRequest extends Controller
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
    public function attributes()
    {
        return [
            'content' => '投稿内容',
        ];
    }
}
