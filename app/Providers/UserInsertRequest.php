<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserInsertRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|regex:/\w{6,18}/',
            'password' => 'required|regex:/\w{6,18}/',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'password.required' => '密码不能为空',
            'username.regex' => '用户名需要6-18位字母数字下划线组成',
            'password.regex' => '密码需要6-18位字母数字下划线组成',
        ];
    }
}
