<?php

namespace App\Http\Requests\Api\V1\Car;

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
            'order_type' => 'nullable|string',
            'order_column' => 'nullable|string',
            'min_price' => 'nullable|integer',
            'max_price' => 'nullable|integer',
            'name' => 'nullable|string',
            'tag_id' => 'nullable|array',
            'brand_id' => 'nullable|integer',
        ];
    }
}
