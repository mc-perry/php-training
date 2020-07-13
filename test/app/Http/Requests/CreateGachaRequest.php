<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class CreateGachaRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'gacha_id' => 'required|integer',
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
            'user_id.required' => 'user_idを入力して下さい。',
            'user_id.integer' => '整数を入力してください。',
            'gacha_id.required' => 'gacha_idを入力して下さい。',
            'gacha_id.integer' => '整数を入力してください。',
        ];
    }
}
