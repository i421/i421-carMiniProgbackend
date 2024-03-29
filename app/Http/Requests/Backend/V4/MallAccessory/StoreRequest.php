<?php

namespace App\Http\Requests\Backend\V4\MallAccessory;

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
            'mall_accessory_classify_id' => 'required|integer',
            'price' => 'required|integer',
            'score_price' => 'required|integer',
            'detail' => 'required|string',
            'carousel' => 'required',
            'size' => 'nullable|string',
            'imgs' => 'required',
            'info' => 'array',
        ];
    }
}
