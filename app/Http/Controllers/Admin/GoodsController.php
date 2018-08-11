<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Good;
use App\Models\Picture;
use Illuminate\Support\Facades\DB;

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
            $goods = Good::selectRaw('lh_goods.*,lh_cates.name as names,lh_pics.path')
                ->where('lh_goods.name', 'like', '%' . $request->input('keywords') . '%')
                ->leftJoin('lh_cates', 'lh_cates.id', '=', 'lh_goods.cate_id')
                ->leftJoin('lh_pics', 'lh_pics.good_id', '=', 'lh_goods.id')
                ->paginate($num);
        } else {
            $goods = Good::selectRaw('lh_goods.*,lh_cates.name as names,lh_pics.path')
                ->leftJoin('lh_cates', 'lh_cates.id', '=', 'lh_goods.cate_id')
                ->leftJoin('lh_pics', 'lh_pics.good_id', '=', 'lh_goods.id')
                ->paginate($num);
        }
        $list = $request->all();
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
        $good = new Good;
        $data['name'] = $good->name = (string)$request->input('name');
        $data['cate_id'] = $good->cate_id = (string)$request->input('cate_id');
        $good->price = (int)$request->input('price');
        $good->total = (float)$request->input('total');
        $good->content = (string)$request->input('content');
        if (!$good->cate_id) {
            return back()->with('error', '顶级菜单不允许出现商品');
        }
        if (!$good->name) {
            return back()->with('error', '请填写商品的名称');
        }
        if (!$request->hasFile('pic')) {
            return back()->with('error', '请选择商品图片');
        }
        DB::beginTransaction();
        $res = false;
        $resGood = $good->save();
        if ($request->hasFile('pic') && $good->id) {
            $pic = $request->file('pic');
            $pic = $pic[0];
            $suffix = $pic->getClientOriginalExtension();
            $name = md5(time() . rand(1, 9999));
            $pic->move('./uploads/shangpin/', $name . '.' . $suffix);
            $pics['path'] = '/uploads/shangpin/' . $name . '.' . $suffix;
            $pics['good_id'] = $good->id;
            $new_pic = new Picture;
            $new_pic->path = $pics['path'];
            $new_pic->good_id = $pics['good_id'];
            $res = $new_pic->save();
        }
        if ($resGood && $res) {
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
        $res = Cate::where('id', '=', $cate_id)->value('name');
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
        $resGood = Good::where('id', '=', $id)->delete();
        $resPic = Picture::where('good_id', '=', $id)->delete();
        if ($resGood && $resPic) {
            $this->returnJson(0, '删除成功');
        } else {
            $this->returnJson(10010, '删除失败');
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
        $goods = Good::where('id', $id)->first();
        $pics = Picture::where('good_id', $id)->first();
        return view('/admin/goods/edit', ['goods' => $goods, 'cates' => $cates, 'pics' => $pics]);
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
        $res_pic = true;
        if ($request->hasFile('pic')) {
            $pic = $request->only('pic')['pic'];
            $suffix = $pic->getClientOriginalExtension();
            $name = md5(time() . rand(1, 9999));
            $pic->move('./uploads/shangpin/', $name . '.' . $suffix);
            $pics['path'] = '/uploads/shangpin/' . $name . '.' . $suffix;
            $pics['good_id'] = $id;
            $res_pic = Picture::where('good_id', $id)->update($pics);
        }
        $res = Good::where('id', $id)->update($data);
        if ($res && $res_pic) {
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
        $res = Good::where('id', $id)->update(['status' => $status]);
        $res ? $this->returnJson(0, $msg) : $this->returnJson(10010, $msg);
    }
}
