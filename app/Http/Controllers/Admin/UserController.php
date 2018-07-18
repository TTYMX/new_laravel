<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\UserInsertRequest;
use Hash;
use DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * 后台用户列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $num = $request->input('num', 10);
        //判断是否有查询条件
        if ($request->input('keywords')) {
            $users = DB::table('lh_users')->where('username', 'like', '%' . $request->input('keywords') . '%')->paginate($num);
        } else {
            $users = DB::table('lh_users')->paginate($num);
        }
        $list = $request->all();
        return view('Admin.user.index', ['users' => $users, 'list' => $list]);
    }

    /**
     * 添加用户界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin.user.add');
    }

    /**
     * 执行用户添加
     * @param UserInsertRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request)
    {
        $data = $request->only('username', 'password', 'email', 'phone', 'auth', 'sex');
        $data['token'] = str_random(50);
        $data['password'] = Hash::make($data['password']);
        $data['pic'] = (string) $this->upload($request, 'pic');
        $res = DB::table('lh_users')->insert($data);
        if ($res) {
            return redirect('/admin/user/index')->with('success', '用户添加成功');
        } else {
            return back()->with('error', '用户添加失败');
        }
    }

    /**
     * 删除用户数据
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        return DB::table('lh_users')->delete($id);
    }

    /**
     * 展示修改页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $users = DB::table('lh_users')->where('id', $id)->first();
        return view('admin/user/edit', ['users' => $users]);
    }

    /**
     * 修改用户数据
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $data = $request->only(['username', 'password', 'email', 'phone']);
        //密码处理 加密
        $data['password'] = Hash::make($data['password']);
        if ($request->hasFile('pic')) {
            $data['pic'] = $this->upload($request, 'pic');
        }
        $id = $request->input('id');
        $res = DB::table('lh_users')->where('id', $id)->update($data);
        if ($res) {
            return redirect('/admin/user/index')->with('success', '用户修改成功');
        } else {
            return back()->with('error', '用户修改失败');
        }
    }

    /**
     * 头像上传
     * @param $request
     * @param $filename
     * @return string
     */
    public function upload($request, $filename)
    {
        if ($request->hasFile($filename)) {
            $suffix = $request->file($filename)->getClientOriginalExtension();
            $name = md5(time() . rand(1, 9999));
            $request->file($filename)->move('./uploads/', $name . '.' . $suffix);
            return '/uploads/' . $name . '.' . $suffix;
        }
    }
}