<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cate;

class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $num = $request->input('num', 5);
        if ($request->input('keywords')) {
            $cates = Cate::selectRaw("*,concat(path,',',id) as paths")
                ->where('name', 'like', '%' . $request->input('keywords') . '%')
                ->orderBy('paths')
                ->paginate($num);
        } else {
            $cates = Cate::selectRaw("*,concat(path,',',id) as paths")
                ->orderBy('paths')
                ->paginate($num);
        }
        foreach ($cates as $k => $v) {
            $arr = explode(',', $v->path);
            $len = count($arr) - 1;
            $cates[$k]->name = str_repeat('&nbsp;|--->', $len) . $v->name;

        }
        $list = $request->all();
        return view('/admin/cate/index', ['cates' => $cates, 'list' => $list]);
    }

    /**
     * 分类添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $cates = self::cates();
        return view('/admin/cate/add', ['cates' => $cates]);
    }

    /**
     * 执行添加分类
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request)
    {
        $data = $request->only(['pid', 'name']);
        if (!$data['name']) {
            return back()->with('error', '分类添加失败,请填写分类名称');
        }
        if ($data['pid'] == 0) {
            $data['path'] = 0;
        } else {
            $res = Cate::where('id', $data['pid'])->first();
            $data['path'] = $res->path . ',' . $data['pid'];
        }
        $cate = new Cate;
        $cate->pid = $data['pid'];
        $cate->name = $data['name'];
        $cate->path = $data['path'];
        $res = $cate->save();
        if ($res) {
            return redirect('/admin/cate/index')->with('success', '分类添加成功');
        } else {
            return back()->with('error', '分类添加失败');
        }
    }

    /*
     * 按照格式要求显示分类数据
     */
    public static function cates()
    {
        $cates = Cate::selectRaw("*,concat(path,',',id) as paths")->orderBy('paths')->get();
        foreach ($cates as $k => $v) {
            $arr = explode(',', $v->path);
            $len = count($arr) - 1;
            $cates[$k]->name = str_repeat('&nbsp;|--->', $len) . $v->name;
        }
        return $cates;
    }

    /**
     * 根据pid获取当前类下的所有子类  递归
     * @param $pid
     * @return array
     */
    public static function catesByPid($pid)
    {
        $res = Cate::where('pid', $pid)->get();
        $data = [];
        foreach ($res as $k => $v) {
            $v->sub = self::catesByPid($v->id);
            $data[] = $v;
        }
        return $data;
    }

    /**
     * 封装方法进行ajax删除操作
     * @param Request $request
     * @return int
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $resCate = Cate::where('pid', '=', $id)->first();
        if ($resCate) {
            $this->returnJson(10010, '存在子类,不允许删除');
        }
        $resGoods = DB::table('lh_goods')->where('cate_id', '=', $id)->first();
        if ($resGoods) {
            $this->returnJson(10011, '存在商品,不允许删除');
        }
        $resDel = Cate::where('id', '=', $id)->delete();
        $resDel ? $this->returnJson(0, '删除成功') : $this->returnJson(10010, '删除失败');
    }

    /**
     * 修改类别页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $cates = Cate::where('id', $id)->first();
        return view('/admin/cate/edit', ['cates' => $cates]);

    }

    /**
     * 执行修改页面
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $data = $request->only(['name']);
        $id = $request->input('id');
        $res = Cate::where('id', $id)->update($data);
        if ($res) {
            return redirect('/admin/cate/index')->with('success', '分类修改成功');
        } else {
            return back()->with('error', '修改失败');
        }
    }
}
