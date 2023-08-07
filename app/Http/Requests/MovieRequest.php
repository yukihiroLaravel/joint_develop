<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'youtube_id' => 'required|max:11',
            'title' => 'max:36',
        ];
    }
    public function attributes()
    {
        return [
            'youtube_id' => 'YouTube動画ID',
            'title' => '動画タイトル',
        ];
    }
}
