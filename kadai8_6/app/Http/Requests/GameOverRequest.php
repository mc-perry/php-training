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
            'exp' => 'required|int',
            'id' => 'required|integer',
            'token' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'exp.required' => 'expを入力して下さい。',
            'exp.int' => '整数を入力してください。',
            'id.required' => 'IDを入力して下さい。',
            'id.integer' => '整数を入力してください。',
            'token.required' => 'tokenを入力して下さい。',
            'token.string' => '文字列を入力してください。',
        ];
    }
}
