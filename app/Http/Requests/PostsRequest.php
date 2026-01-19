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
            'content' => 'required|max:140',
            'image' => 'nullable|image|max:2048|dimensions:min_width=100,min_height=100,max_width=3000,max_height=3000',
        ];
    }
    public function attributes()
    {
        return [
            'content' => '投稿',
        ];
    }


}