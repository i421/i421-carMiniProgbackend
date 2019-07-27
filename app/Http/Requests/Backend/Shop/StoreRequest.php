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
            'province' => 'required|string',
            'city' => 'required|string',
            'area' => 'required|string',
            'detail_address' => 'required|string',
            'img_url' => 'required|image',
            'license_url' => 'required|image',
            'info' => 'nullable|array',
            'lat' => 'required|integer',
            'lng' => 'required|integer',
        ];
    }
}
