<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\UserInsertRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;

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
        if ($request->input('keywords')) {
            $keywords = $request->input('keywords');
            $users = User::select()->where('username','like', '%' . $keywords . '%')->paginate($num);
        } else {
            $users = User::select()->paginate($num);
        }
        $list = $request->all();
        return view('admin.user.index', ['users' => $users, 'list' => $list]);
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
        $data['pic'] = (string)$this->upload($request, 'pic');
	    $user = new User;
        $user->username = $data['username'];
        $user->password = $data['password'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->token = $data['token'];
        $user->auth = isset($data['auth']) ? $data['auth'] : 0;
        $user->sex = $data['sex'];
        $user->pic = $data['pic'];
        $res = $user->save();
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
        return User::where('id',$id)->delete();
    }

    /**
     * 展示修改页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $users = User::select()->where('id', $id)->first();
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
        $res = User::where('id', $id)->update($data);
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
        if (!file_exists('./uploads')) {
            mkdir('./uploads');
        }
        if ($request->hasFile($filename)) {
            $suffix = $request->file($filename)->getClientOriginalExtension();
            $name = md5(time() . rand(1, 9999));
            $request->file($filename)->move('./uploads/', $name . '.' . $suffix);
            return '/uploads/' . $name . '.' . $suffix;
        }
    }
}
