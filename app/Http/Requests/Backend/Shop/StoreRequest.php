<?php

namespace App\Http\Requests\Backend\Shop;

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
            'name' => 'required|string',
            'phone' => 'required|integer',
            'province' => 'nullable|string',
            'city' => 'nullable|string',
            'area' => 'nullable|string',
            'detail_address' => 'nullable|string',
            'img_url' => 'nullable|image',
            'license_url' => 'nullable|image',
            'info' => 'nullable|array',
            'lat' => 'nullable|integer',
            'lng' => 'nullable|integer',
        ];
    }
}
