<?php

namespace App\Http\Requests\Backend\Order;

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
            'car_name' => 'nullable|string',
            'customer_name' => 'nullable|string',
            'time' => 'nullable|array',
            'phone' => 'nullable|string',
            'status' => 'nullable|array',
            'order_no' => 'nullable|string',
        ];
    }
}
