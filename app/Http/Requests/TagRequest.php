<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TagRequest extends FormRequest
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
            'name' => 'required|string|max:50|unique:tags,name,' . $this->route('tag')->id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'タグ名を入力してください',
            'name.max'      => 'タグ名は50文字以内で入力してください',
            'name.unique'   => 'このタグ名は既に使われています',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->route('tags.index')->withErrors($validator)->withInput()->with('error_tag_id', $this->route('tag')->id)
        );
    }
}
