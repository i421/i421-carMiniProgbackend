<?php

namespace App\Http\Requests\Api\V4\MallAddress;

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
            'default' => 'required|integer',
            'name' => 'required|string',
            'phone' => 'required|string',
            'city' => 'required|string',
            'detail_address' => 'required|string',
        ];
    }
}
