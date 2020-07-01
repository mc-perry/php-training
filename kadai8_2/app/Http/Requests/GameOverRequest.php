<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class GameOverRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer',
            'exp' => 'required|int'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'IDを入力して下さい。',
            'id.integer' => '整数を入力してください。',
            'exp.required' => 'expを入力して下さい。',
            'exp.int' => '整数を入力してください。',
        ];
    }
}
