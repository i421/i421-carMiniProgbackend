<?php

namespace App\Http\Requests\Backend\Customer;

use Illuminate\Foundation\Http\FormRequest;

class IsSellerRequest extends FormRequest
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
            'is_seller' => 'nullable|boolean',
        ];
    }
}
