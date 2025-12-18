<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        $userId = $this->route('id');

        return [
            'name' => [
                'required',
                'string',
                'max:255',],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),],
            'password' => [
                'nullable',
                'confirmed',
                'min:6',],
        ];
    }
}
