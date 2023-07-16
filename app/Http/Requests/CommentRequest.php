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
            'comment.' . $this->post_id => 'required|max:140',
        ];
    }

    public function messages()
    {
        return [
            'comment' => 'コメント',
            'comment.*.required' => 'コメントは必須です',
            'comment.*.max' => 'コメントは140文字以下で入力して下さい',
        ];
    }

}