<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReplyRequest extends FormRequest
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
            'content' => 'required|max:140|regex:/\S/',
        ];
    }

    // バリデーションエラーメッセージ
    public function messages()
    {
        return [
            'content.required' => '返信内容を入力してください。',
            'content.max' => '返信内容は140文字以内で入力してください。',
            'content.regex' => '返信内容には空白や改行のみを入力することはできません。',
        ];
    }

    // バリデーションに失敗した時のレスポンス
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'バリデーションエラー',
            'errors' => $validator->errors(),
        ], 422));
    }
}
