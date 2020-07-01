<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'IDを入力して下さい。',
            'id.integer' => '整数を入力してください。',
        ];
    }
}
