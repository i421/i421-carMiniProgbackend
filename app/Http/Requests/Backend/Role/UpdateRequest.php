<?php

namespace App\Http\Requests\Backend\Role;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name' => 'required|string',
            'display_en_name' => 'required|string',
            'display_zh_name' => 'required|string',
            'description' => 'string|nullable',
            'status' => 'required|integer',
        ];
    }
}
