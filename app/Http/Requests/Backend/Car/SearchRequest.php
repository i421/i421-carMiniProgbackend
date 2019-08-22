<?php

namespace App\Http\Requests\Backend\Car;

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
            'brand_id' => 'nullable|string',
            'min_price' => 'nullable|integer',
            'max_price' => 'nullable|integer',
        ];
    }
}
