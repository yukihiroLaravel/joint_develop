<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Rule;

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
            'text' => 'nullable|string|max:140',
            'image' => 'nullable|image',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $text = $this->input('text');
            $image = $this->file('image');

            if (is_null($text) && is_null($image)) {
                $validator->errors()->add('text_or_image', 'テキストまたは画像のいずれかが必要です。');
            }
        });
    }
}