<?php

namespace App\Http\Requests\Backend\Shop;

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
            'address_id' => 'required|integer',
            'img_url' => 'nullable|array',
            'detail_address' => 'nullable|string',
            'info' => 'nullable|array',
        ];
    }
}
