<?php

namespace App\Http\Requests\Backend\V3\Package;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'maintenance_count' => 'required|integer',
            'price' => 'required|integer',
            'min_price' => 'required|string',
            'max_price' => 'required|string',
            'desc' => 'string',
        ];
    }
}
