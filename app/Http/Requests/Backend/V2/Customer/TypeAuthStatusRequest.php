<?php

namespace App\Http\Requests\Backend\V2\Customer;

use Illuminate\Foundation\Http\FormRequest;

class TypeAuthStatusRequest extends FormRequest
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
            'id' => 'nullable|integer',
            'auth' => 'nullable|boolean',
        ];
    }
}
