<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminPost;
use App\Models\User;
use Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        //初始化函数 暂时不用
    }

    /**
     * 登录页面
     */
    public function index()
    {
        return view('admin/login/index');
    }

    /**
     * @param StoreAdminPost $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkLogin(StoreAdminPost $request)
    {
        $fields = $request->only(['username', 'password']);
        $userInfo = User::select()->where('username',$fields['username'])->first();
        if (!$userInfo) {
            return back()->with('error', '用户名或密码不正确');
        }
        $res = Hash::check($fields['password'], $userInfo->password);
        if ($res) {
            session(['uid' => $userInfo->id, 'username' => $userInfo->username]);
            return redirect('/admin/index')->with('success', '欢迎' . $userInfo->username . '登录');
        } else {
            return back()->with('error', '用户名或密码不正确');
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        session(['uid'=>'','username'=>'']);
        return redirect('/admin/login')->with('error','退出成功');
    }
}