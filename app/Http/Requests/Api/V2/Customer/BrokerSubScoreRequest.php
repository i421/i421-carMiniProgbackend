<?php

namespace App\Http\Requests\Api\V2\Customer;
use Illuminate\Foundation\Http\FormRequest;

class BrokerSubScoreRequest extends FormRequest
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
            'score' => 'required|integer',
        ];
    }
}
