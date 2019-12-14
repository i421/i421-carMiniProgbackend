<?php

namespace App\Http\Requests\Backend\FightingGroup;

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
            'id' => 'required|integer',
            'group_type' => 'required|integer',
            'group_price' => 'required|integer',
            'time_range' => 'required|array',
            'off' => 'required|integer',
            //'group_recommend' => 'required|integer',
            'total_num' => 'nullable|integer',
        ];
    }
}
