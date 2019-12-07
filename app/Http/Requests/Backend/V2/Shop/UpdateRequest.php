<?php

namespace App\Http\Requests\Backend\V2\Shop;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * * @return bool
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
            'shop_id' => 'required|integer',
            'name' => 'required|string',
            'type' => 'required|string',
            'desc' => 'required|string',
            'phone' => 'required|string',
            'lat' => 'required|string',
            'lng' => 'required|string',
            'img' => 'required|array',
            'address' => 'required|string',
        ];
    }
}
