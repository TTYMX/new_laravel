<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\admin\CateController;
use Illuminate\Http\Request;
use App\Models\Good;
use App\Models\Picture;


class IndexController extends Controller
{
    /**
     * 首页显示的数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        echo '<h1>首页展示</h1>';
        $goods = Good::selectRaw('lh_goods.*,lh_pics.path')
            ->leftJoin('lh_pics', 'lh_pics.good_id', '=', 'lh_goods.id')
            ->paginate(10);
        return view('home/index/index', ['goods' => $goods]);
    }

    /**
     * 详情页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $good = Good::select()->where('id',$id)->first();
        $pic = Picture::select()->where('good_id',$id)->first();
        return view('home/index/detail',['good' => $good,'pic'=>$pic]);
    }



    public function takeGoods(Request $request)
    {
        $cate = CateController::catesByPid(0);
        if ($request->input('pid')) {
            $pid = $request->input('pid');
            $cate1 = CateController::catesByPid($pid);
        } else {
            $cate1 = CateController::catesByPid(1);
        }
        $list = $request->all();
        if ($request->input('gname')) {
            $gname = $request->input('gname');
            if ($request->input('lprice') && $request->input('hprice')) {
                $lprice = $request->input('lprice');
                $hprice = $request->input('hprice');
                if ($request->input('sort')) {
                    $sort = $request->input('sort');
                    $goods = DB::table('lh_goods')->whereBetween('price', [$lprice, $hprice])->where('name',
                        'like', "%{$gname}%")->orderBy('price', $sort)->paginate(10);
                } else {
                    $goods = DB::table('lh_goods')->whereBetween('price', [$lprice, $hprice])->where('name',
                        'like', "%{$gname}%")->paginate(10);
                }
                foreach ($goods as $k => $v) {
                    $pic = DB::table('lh_pics')->where('goods_id', $v->id)->first();
                    $goods[$k]->path = $pic->path;
                }
            } else {
                if ($request->input('sort')) {
                    $sort = $request->input('sort');
                    $goods = DB::table('lh_goods')->where('name', 'like', "%{$gname}%")->orderBy('price',
                        $sort)->paginate(10);
                } else {
                    $goods = DB::table('lh_goods')->where('name', 'like', "%{$gname}%")->paginate(10);
                }
                foreach ($goods as $k => $v) {
                    $pic = DB::table('lh_pics')->where('goods_id', $v->id)->first();
                    $goods[$k]->path = $pic->path;
                }
            }
        } else {
            $goods = DB::table('lh_goods')->paginate(10);
            foreach ($goods as $k => $v) {
                $pic = DB::table('lh_pics')->where('goods_id', $v->id)->first();
                $goods[$k]->path = $pic ? $pic->path : '';
            }
        }
        if ($request->input('cid')) {
            $cid = $request->input('cid');
            $cate_id = DB::table('lh_cates')->where('path', 'like', "%{$cid}%")->lists('id');
            $cate_id[] = (int)$cid;
            if ($request->input('lprice') && $request->input('hprice')) {
                $lprice = $request->input('lprice');
                $hprice = $request->input('hprice');
                //判断是否有升降序
                if ($request->input('sort')) {
                    $sort = $request->input('sort');
                    $goods = DB::table('lh_goods')->whereBetween('price', [$lprice, $hprice])->wherein('cate_id', $cate_id)->orderBy('price', $sort)->paginate(10);
                } else {
                    $goods = DB::table('lh_goods')->whereBetween('price', [$lprice, $hprice])->wherein('cate_id', $cate_id)->paginate(10);

                }
                foreach ($goods as $k => $v) {
                    $pic = DB::table('lh_pics')->where('goods_id', $v->id)->first();
                    $goods[$k]->path = $pic->path;
                }
            } else {
                if ($request->input('sort')) {
                    $sort = $request->input('sort');
                    $goods = DB::table('lh_goods')->wherein('cate_id', $cate_id)->orderBy('price', $sort)->paginate(10);
                } else {
                    $goods = DB::table('lh_goods')->wherein('cate_id', $cate_id)->paginate(10);

                }
                foreach ($goods as $k => $v) {
                    $pic = DB::table('lh_pics')->where('goods_id', $v->id)->first();
                    $goods[$k]->path = $pic->path;
                }
            }
        } else {
            $goods = '';
        }
    }
}

