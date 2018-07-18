<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

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
            $cates = DB::table('lh_cate')
                ->where('name', 'like', '%' . $request->input('keywords') . '%')
                ->select(DB::raw("*,concat(path,',',id) as paths"))
                ->orderBy('paths')
                ->paginate($num);
        } else {
            $cates = DB::table('lh_cate')
                ->select(DB::raw("*,concat(path,',',id) as paths"))
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
        if ($data['pid'] == 0) {
            $data['path'] = 0;
        } else {
            $res = DB::table('lh_cate')->where('id', $data['pid'])->first();
            $data['path'] = $res->path . ',' . $data['pid'];
        }
        $res = DB::table('lh_cate')->insert($data);
        if ($res) {
            return redirect('/admin/cate/index')->with('success', '分类添加成功');

        } else {
            return back()->with('error', '用户添加失败');
        }
    }

    /*
     * 按照格式要求显示分类数据
     */
    public static function cates()
    {
        $cates = DB::select("select *,concat(path,',',id) as paths from lh_cate order by paths");
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
        $res = DB::table('lh_cate')->where('pid', $pid)->get();
        $data = [];
        foreach ($res as $k => $v) {
            $v->sub = self::getCatesByPid($v->id);
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
        $res1 = DB::table('lh_cate')->where('pid', '=', $id)->first();
        $res2 = DB::table('goods')->where('cate_id', '=', $id)->first();
        if (!$res1 && !$res2) {
            $res = DB::table('lh_cate')->where('id', '=', $id)->delete();
            return $res;
        } else {
            return 0;
        }
    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $cates = DB::table('lh_cate')->where('id', $id)->first();
        // dd($cates);

        //解析模板
        return view('/admin/cate/edit', ['cates' => $cates]);

    }

    public function update(Request $request)
    {
        $data = $request->only(['name']);
        $id = $request->input('id');
        $res = DB::table('lh_cate')->where('id', $id)->update($data);
        if ($res) {
            return redirect('/admin/cate/index')->with('success', '用户修改成功');
        } else {
            return back()->with('error', '修改失败');
        }
    }
}
