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
                ->select('lh_goods.*', 'lh_cates.name as names')
                ->join('lh_cates', 'lh_cates.id', '=', 'lh_goods.cate_id')
                ->paginate($num);
        } else {
            $goods = DB::table('lh_goods')
                ->select('lh_goods.*', 'lh_cates.name as names')
                ->join('lh_cates', 'lh_cates.id', '=', 'lh_goods.cate_id')
                ->paginate($num);
        }
        $list = $request->all();
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
        $data['name'] = (string) $request->input('name');
        $data['cate_id'] = (int) $request->input('cate_id');
        $data['price'] = (float) $request->input('price');
        $data['total'] = (int) $request->input('total');
        $data['content'] = (string) $request->input('content');
        if (!$data['cate_id']) {
            return back()->with('error', '顶级菜单不允许出现商品');
        }
        if (!$data['name']) {
            return back()->with('error', '请填写商品的名称');
        }
        if (!$request->only('pic')) {
            return back()->with('error', '请选择商品图片');
        }
        $data['created_time'] = time();
        DB::beginTransaction();
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
            DB::commit();
            return redirect('/admin/goods/index')->with('success', '商品添加成功');
        } else {
            DB::rollBack();
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
        $cates = CateController::cates();
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
        $id = $request->input('id');
        $data = $request->only(['name', 'price', 'total', 'cate_id', 'status']);
        $data['updated_at'] = time();
        if ($request->hasFile('pic')) {
            $data['pic'] = UserController::upload($request, 'pic');
        }
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
    public function updateStatus(Request $request)
    {
        $id = (int)$request->input('id');
        $status = (int)$request->input('status');
        if ($status == 2) {
            $status = 1;
            $msg = '上架';
        } else {
            $status = 2;
            $msg = '下架';
        }
        $res = DB::table('lh_goods')->where('id', $id)->update(['status' => $status]);
        $res ? $this->returnJson(0,$msg) : $this->returnJson(10010,$msg);
    }
}
