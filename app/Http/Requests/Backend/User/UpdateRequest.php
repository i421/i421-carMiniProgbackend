<?php

namespace App\Http\Requests\Backend\User;

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
            'nickname' => 'string',
            'email' => 'required|email',
            'phone' => 'string',
            'password' => 'required|string|min:6',
            'role_id' => 'required|integer|exists:roles,id',
            'avater' => 'image',
            'info' => 'array',
        ];
    }
}
