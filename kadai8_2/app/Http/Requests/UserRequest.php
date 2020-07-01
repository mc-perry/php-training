<?php

/**
 * ユーザー登録
 */

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class UserRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickname' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nickname.required' => 'ユーザ名を入力して下さい。',
        ];
    }
}
