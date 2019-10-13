<?php

namespace App\Http\Requests\Api\V1\ShopRepair;

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
            'name' => 'nullable|string',
            'shop_id' => 'nullable|integer',
            'phone' => 'nullable|string',
            'time' => 'nullable|array',
        ];
    }
}
