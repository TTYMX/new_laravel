<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminPost extends FormRequest
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
            'username' => 'required|min:3',
            'password' => 'required|min:5',
        ];
    }

    public function messages()
    {
        return [
          'username.required' => '用户名不能为空',
          'username.min' => '用户名不能少于五位',
          'password.required' => '密码不能少于五位',
          'password.min' => '密码不能少于五位',
        ];
    }
}
