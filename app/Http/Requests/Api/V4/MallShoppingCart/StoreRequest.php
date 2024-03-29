<?php

namespace App\Http\Requests\Api\V4\MallShoppingCart;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'customer_id' => 'required|integer',
            'mall_accessory_id' => 'required|integer',
            'count' => 'required|string',
            'price' => 'required|string',
            'detail' => 'nullable',
        ];
    }
}
