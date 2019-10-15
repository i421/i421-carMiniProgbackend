<?php

namespace App\Http\Requests\Backend\ShopRepair;

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
            'phone' => 'required|integer',
            'address' => 'required|string',
            'img' => 'nullable|image',
            'shop_id' => 'nullable|integer',
            'lat' => 'required|string',
            'lng' => 'required|string',
        ];
    }
}
