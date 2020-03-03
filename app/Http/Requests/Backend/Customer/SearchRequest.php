<?php

namespace App\Http\Requests\Backend\Customer;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'nickname' => 'nullable|string',
            'phone' => 'nullable|string',
            'time' => 'nullable|array',
            'auth' => 'nullable|array',
            'is_seller' => 'nullable|array',
            'is_buyer' => 'nullable|array',
            'pageSize' => 'nullable',
        ];
    }
}
