<?php

namespace App\Http\Requests\Api\V1\Payment;

use Illuminate\Foundation\Http\FormRequest;

class ScoreRequest extends FormRequest
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
            'payment_count' => 'required|integer',
            'customer_id' => 'required|integer',
            'mall_accessory_id' => 'nullable|integer',
            'mall_address_id' => 'nullable|integer',
            'mall_accessory_count' => 'nullable|integer',
            'mall_accessory_detail' => 'nullable|array',
        ];
    }
}
