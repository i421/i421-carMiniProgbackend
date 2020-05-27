<?php

namespace App\Http\Requests\Api\V1\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PreOrderRequest extends FormRequest
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
            //'payment_count' => 'required|integer',
            'payment_count' => 'required|between:0,9999999.9',
            'customer_id' => 'required|integer',
            'car_id' => 'nullable|integer',
            'shop_id' => 'nullable|integer',
            'mall_accessory_id' => 'nullable|integer',
            'mall_address_id' => 'nullable|integer',
            'mall_accessory_count' => 'nullable|integer',
            'mall_accessory_detail' => 'nullable|array',
            'type' => 'nullable|integer',
        ];
    }
}
