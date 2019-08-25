<?php

namespace App\Http\Requests\Api\V1\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBasicInfoRequest extends FormRequest
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
            'openid' => 'required|string',
            'avatar' => 'required|string',
            'nick_name' => 'required|string',
            'gender' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'area' => 'required|string',
            'detail_address' => 'required|string',
        ];
    }
}
