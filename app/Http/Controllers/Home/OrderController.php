<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Good;
use DB;


class OrderController extends Controller
{
    /**
     * 立即购买
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function buy(Request $request)
    {
        $id = (int)$request->input('id');
        $goodInfo = Good::select()->where('id', $id)->first();
        if ($goodInfo->total < 1) {
            echo '卖完了,别捣乱';
            exit;
        }
        $order = new Order;
        $order->good_id = $goodInfo->id;
        $order->price = $goodInfo->price;
        $order->order_num = str_random(32);
        $order->status = 1;
        $order->user_id = session('uid') ? session('uid') : 0;
        $order->openid = session('openid') ? session('openid') : 0;
        DB::beginTransaction();
        $resOrder = $order->save();
        $resGood = Good::where('id', $id)->update(['total' => $goodInfo->total - 1]);
        if ($resOrder && $resGood) {
            DB::commit();
            $this->returnJson(0,'购买成功');
        } else {
            DB::rollback();
            $this->returnJson(10010,'购买失败');
        }
    }

    /**
     * 购买列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function buyList(Request $request)
    {
        $buyList = Order::selectRaw('lh_orders.*,lh_goods.name,lh_pics.path')
            ->leftJoin('lh_goods','lh_orders.good_id','=','lh_goods.id')
            ->leftJoin('lh_pics','lh_orders.good_id','=','lh_pics.good_id')
            ->where('user_id','=',session('uid'))
            ->get();
        $this->returnJson(0,$buyList);
    }
}

