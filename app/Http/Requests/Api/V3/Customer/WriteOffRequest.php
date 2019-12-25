<?php

namespace App\Http\Requests\Api\V3\Customer;

use Illuminate\Foundation\Http\FormRequest;

class WriteOffRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'package_id' => 'required|exists:packages,id',
            'time' => 'required',
            'merchant_id' => 'required|exists:customers,id',
        ];
    }
}
