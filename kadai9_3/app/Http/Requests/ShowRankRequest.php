<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class ShowRankRequest extends BaseRequest
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
            'from' => 'required|integer|min:0',
            'to' => 'required|integer',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'from.required' => 'fromを入力して下さい。',
            'from.integer' => '整数を入力してください。',
            'to.required' => 'toを入力して下さい。',
            'to.integer' => '整数を入力してください。'
        ];
    }
}
