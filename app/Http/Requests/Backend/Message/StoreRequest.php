<?php

namespace App\Http\Requests\Backend\Message;

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
            'sub_title' => 'required|string',
            'content' => 'required|string',
            'status' => 'nullable|boolean',
            'start_time' => 'required|date',
        ];
    }
}
