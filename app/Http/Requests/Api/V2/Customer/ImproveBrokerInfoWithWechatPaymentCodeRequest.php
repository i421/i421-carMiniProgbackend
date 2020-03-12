<?php

namespace App\Http\Requests\Api\V2\Customer;

use Illuminate\Foundation\Http\FormRequest;

class ImproveBrokerInfoWithWechatPaymentCodeRequest extends FormRequest
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
            'openid' => 'required|string',
            'name' => 'required|string',
            'id_card' => 'required|string',
            'wechat_payment_code' => 'required|string',
            'bank_card' => 'string',
            'id_card_front_path' => 'string',
            'id_card_back_path' => 'string',
        ];
    }
}
