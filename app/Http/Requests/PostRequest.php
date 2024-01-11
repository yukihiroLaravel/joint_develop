<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
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
            'img_path' => 'image|mimes:png,jpg|max:2048',
        ];
    }
    public function attributes()
    {
        return [
            'content' => '投稿内容',
            'img_path' => '画像',
        ];
    }
}
