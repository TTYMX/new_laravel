<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order as orderModel;
use App\Models\Good as goodModel;
use DB;


class CardController extends Controller
{
    public function card(Request $request)
    {
        return view('home/index/card');
    }

    public function buy(Request $request)
    {
        $id = (int)$request->input('id');
        $uid = session('uid');
        $goodInfo = goodModel::select()->where('id',$id)->first();
        $data[] = $goodInfo->name;
        $res = orderModel::insert('id','uid')->get();
        dd($res);
        var_dump($uid);
        dd($goodInfo);
        $res = DB::table('lh_goods')->where('id',$id)->decrement('total',1);
        echo '购买成功';
    }
}

