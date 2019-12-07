<?php

namespace App\Http\Requests\Backend\Car;

use Illuminate\Foundation\Http\FormRequest;

class SetGroupRequest extends FormRequest
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
            'car_id' => 'required|integer',
            'group_price' => 'required|integer',
            'time_range' => 'required|array',
            'total_num' => 'nullable|integer',
            'group_type' => 'required|string',
            'off' => 'required|integer',
            'group_recommend' => 'required|integer',
        ];
    }
}
