<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'comment' => 'required|string|max:1000',
            'rating_service' => 'nullable|integer|min:1|max:5',
            'rating_cost' => 'nullable|integer|min:1|max:5',
            'rating_quality' => 'nullable|integer|min:1|max:5',
        ];
    }

    public function attributes()
    {
        return [
            'comment' => 'レビュー',
            'rating_service' => '接客・対応',
            'rating_cost' => '料金',
            'rating_quality' => '技術',
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => 'レビューを入力してください。',
            'comment.string'   => 'レビューは文字列で入力してください。',
            'comment.max'      => 'レビューは、1000文字以下にしてください。',
        ];
    }
}