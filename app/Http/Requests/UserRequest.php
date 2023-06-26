<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user())],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_image' => 'file|image|mimes:jpeg,png,jpg|max:1024|dimensions:max_width=1000',
        ];
    }

    public function messages()
    {
        return [
            'profile_image.max' => 'ファイルサイズが1MBを超えています。',
            'profile_image.dimensions' => '画像の横幅は最大1000pxです。',
        ];
    }
}
