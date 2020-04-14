<?php

namespace App\Http\Requests\Backend\V4\MallAccessoryClassify;

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
            'type' => 'required|integer',
            'p_name' => 'required|string',
            'p_id' => 'required|integer',
            'height' => 'required|integer',
            'img' => 'image',
            'info' => 'array',
        ];
    }
}
