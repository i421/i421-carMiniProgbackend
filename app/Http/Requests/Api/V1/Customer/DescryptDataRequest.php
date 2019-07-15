<?php

namespace App\Http\Requests\Api\V1\Customer;

use Illuminate\Foundation\Http\FormRequest;

class DescryptDataRequest extends FormRequest
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
            'iv' => 'required|string',
            'encryptedData' => 'required|string',
            'recommender' => 'nullable|string|size:40',
        ];
    }
}
