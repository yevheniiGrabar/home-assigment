<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordUpdateRequest extends FormRequest
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
            'name' => 'string',
            'image' => 'url',
            'category_id' => 'exists:categories,id',
            'user_id' => 'exists:users,id',
        ];
    }
}
