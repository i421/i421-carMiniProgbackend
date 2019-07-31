<?php

namespace App\Http\Requests\Backend\Car;

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
            'brand_id' => 'required|integer',
            'guide_price' => 'required|string',
            'final_price' => 'required|string',
            'car_price' => 'required|string',
            'remarks' => 'nullable|string',
            'info' => 'nullable|array',
            'carousel' => 'required',
            'avatar' => 'required|image',
            'attr' => 'required|array',
        ];
    }
}
