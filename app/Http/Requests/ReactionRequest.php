<?php

namespace App\Http\Requests;

use App\Reaction;
use Illuminate\Foundation\Http\FormRequest;

class ReactionRequest extends FormRequest
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
            'reaction_type' => 'nullable|in:' . implode(',', array_keys(Reaction::TYPES)),
            'encouragement' => 'nullable|string|max:30',
        ];
    }

    public function attributes()
    {
        return [
            'reaction_type' => 'リアクション',
            'encouragement' => 'ひとことハゲマシ',
        ];
    }
}
