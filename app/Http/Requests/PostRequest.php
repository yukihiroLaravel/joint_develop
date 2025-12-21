<?php

namespace App\Http\Requests;

use App\Tag;
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
            'tag_ids.*'    => 'exists:tags,id',
            'new_tags'     => 'nullable|string|max:50',
        ];
    }

    public function attributes()
    {
        return [
            'content' => '投稿内容',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('new_tags')) {
                $names = array_unique( array_filter(array_map('trim', explode(',', $this->new_tags))));

                $exists = \App\Tag::whereIn('name', $names)->pluck('name')->toArray();

                if (!empty($exists)) {
                    $validator->errors()->add(
                        'new_tags',
                        '既存タグはチェックボックスから選択してください：' . implode(', ', $exists)
                    );
                }
            }
        });
    }
}
