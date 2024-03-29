<?php

namespace App\Http\Requests\Backend\Car;

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
            'brand_id' => 'required|integer',
            'guide_price' => 'required|string',
            'final_price' => 'required|string',
            'car_price' => 'required|string',
            'remarks' => 'nullable|string',
            'attr' => 'required|string',
            'customize' => 'nullable|string',
            'model' => 'nullable|string',
            'staging24' => 'nullable|integer',
            'staging36' => 'nullable|integer',
            'staging48' => 'nullable|integer',
            'down_payment' => 'nullable|integer',
            'carousel' => 'nullable',
            'avatar' => 'nullable|image',
            'height' => 'nullable|integer',
        ];
    }
}
