<?php

namespace App\Http\Requests\Api\V3\Comment;

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
            'forum_id' => 'required|integer',
            'content' => 'required|string',
            'customer_id' => 'required|integer',
            'pid' => 'required|integer',
        ];
    }
}
