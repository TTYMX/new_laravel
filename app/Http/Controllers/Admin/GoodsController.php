<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $num = $request->input('num', 5);
        if ($request->input('keywords')) {
            $goods = DB::table('lh_goods')
                ->where('lh_goods.name', 'like', '%' . $request->input('keywords') . '%')
                ->select('lh_goods.*', 'lh_cate.name as names')
                ->join('lh_cate', 'lh_cate.id', '=', 'lh_goods.cate_id')
                ->paginate($num);
        } else {
            $goods = DB::table('lh_goods')
                ->select('lh_goods.*', 'lh_cate.name as names')
                ->join('lh_cate', 'lh_cate.id', '=', 'lh_goods.cate_id')
                ->paginate($num);
        }
        $list = $request->all();
        foreach ($goods as $k => $v) {
            if ($v->status == 1) {
                $goods[$k]->status = '上架';
            } elseif ($v->status == 2) {
                $goods[$k]->status = '下架';
            }
        }
        foreach ($goods as $k => $v) {
            $pic = DB::table('lh_pics')->where('goods_id', $v->id)->first();
            if ($pic) {
                $goods[$k]->pic = $pic->path;
            } else {
                $goods[$k]->pic = '';
            }

        }
        return view('admin/goods/index', ['goods' => $goods, 'list' => $list]);
    }

    /**
     * 添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $cates = CateController::cates();
        return view('admin/goods/add', ['cates' => $cates]);
    }

    /**
     * 执行添加
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request)
    {
        $data = $request->only(['name', 'cate_id', 'price', 'total', 'content']);
        $insertId = DB::table('lh_goods')->insertGetId($data);
        $pic = $request->only('pic')['pic'];
        foreach ($pic as $k => $v) {
            $suffix = $v->getClientOriginalExtension();
            $name = md5(time() . rand(1, 9999));
            $v->move('./uploads/', $name . '.' . $suffix);
            $pics[]['path'] = '/uploads/' . $name . '.' . $suffix;
            $pics[$k]['goods_id'] = $insertId;
        }
        $res = DB::table('lh_pics')->insert($pics);
        if ($insertId && $res) {
            return redirect('/admin/goods/index')->with('success', '商品添加成功');
        } else {
            return back()->with('error', '商品添加失败');
        }


    }

    /**
     * @param $cate_id
     * @return mixed
     */
    public function bycateid($cate_id)
    {
        $res = DB::table('cate')->where('id', '=', $cate_id)->value('name');
        return $res;
    }


    /**
     * 删除
     * @param Request $request
     * @return bool
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $res = DB::table('lh_goods')->where('id', '=', $id)->delete();
        $ress = DB::table('lh_pics')->where('goods_id', '=', $id)->delete();
        if ($res && $ress) {
            return true;
        }
    }

    /**
     * 修改商品页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $cates = CateController::getCates();
        $id = $request->input('id');
        $goods = DB::table('lh_goods')->where('id', $id)->first();
        return view('/admin/goods/edit', ['lh_goods' => $goods, 'cates' => $cates]);
    }

    /**
     * 修改商品
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $data = $request->only(['name', 'price', 'total', 'cate_id', 'status']);
        if ($request->hasFile('pic')) {
            $data['pic'] = UserController::upload($request, 'pic');
        }
        $id = $request->input('id');
        $res = DB::table('lh_goods')->where('id', $id)->update($data);
        if ($res) {
            return redirect('/admin/goods/index')->with('success', '商品修改成功');
        } else {
            return back()->with('error', '商品修改失败');
        }
    }

    /**
     * 封装方法修改上架下架
     * @param Request $request
     * @return string
     */
    public function updatestatus(Request $request)
    {
        $id = $request->input('id');
        $status = DB::table('lh_goods')->where('id', '=', $id)->value('status');
        if ($status == 1) {
            DB::table('lh_goods')->where('id', $id)->update(['status' => '2']);
            return '下架';
        } elseif ($status == 2) {
            DB::table('lh_goods')->where('id', $id)->update(['status' => '1']);
            return '上架';
        }
    }
}
