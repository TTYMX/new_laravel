<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Good;
use App\Models\Picture;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    /**
     * 首页显示的数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $goods = Good::selectRaw('lh_goods.*,lh_pics.path')
            ->leftJoin('lh_pics', 'lh_pics.good_id', '=', 'lh_goods.id')
            ->paginate(10);
        $this->returnJson(0,$goods);
        return view('home/index/index', ['goods' => $goods]);
    }

    /**
     * 首页展示页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexShow()
    {
        return view('home/index/index');
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
        $this->returnJson(0,['good' => $good,'pic'=>$pic]);
    }

    /**
     * 详情展示页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailShow(Request $request)
    {
        $id = $request->input('id');
        return view('home/index/detail',['id'=>$id]);
    }
}

