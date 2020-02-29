<?php

namespace App\Http\Requests\Api\V3\Forum;

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
            'title' => 'required|string',
            'content' => 'required|string',
            'publish_at' => 'required|date',
            'customer_id' => 'required|integer',
            'imgs' => 'required|string',
        ];
    }
}
