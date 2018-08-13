<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Good;
use App\Models\Picture;
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
        $goodInfo = Good::where('id', $id)->first();
        if ($goodInfo->total < 1) {
            return view('home/order/fail',['message'=>'卖完了']);
        }
        $order = new Order;
        $order->good_id = $goodInfo->id;
        $order->price = $goodInfo->price;
        $order->order_num = str_random(32);
        $order->status = 1;
        $order->user_id = session('uid') ? session('uid') : 0;
        DB::beginTransaction();
        $resOrder = $order->save();
        $resGood = Good::where('id', $id)->update(['total' => $goodInfo->total - 1]);
        if ($resOrder && $resGood) {
            DB::commit();
            return view('home/order/success',['message'=>'购买成功']);
        } else {
            DB::rollback();
            return view('home/order/fail',['message'=>'购买失败']);
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
        if ($request->ajax()) {
            $this->returnJson(0,$buyList);
        } else {
            return view('home/order/index', ['cards' => $buyList]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ping(Request $request)
    {
        $id = (int) $request->input('id');
        $orderInfo = Order::find($id);
        $goodInfo = Good::find($orderInfo->good_id);
        $picInfo = Picture::where('good_id',$orderInfo->good_id)->first();
        return view('home/order/ping',['order'=>$orderInfo,'good'=>$goodInfo,'pic'=>$picInfo]);
    }

    /**
     * @param Request $request
     */
    public function comment(Request $request)
    {
        $id = (int) $request->input('id');
        $text = (int) $request->input('text');
        $data = array('comment'=>$text,'is_comment'=>1);
        $res = Order::where('id',$id)->update($data);
        if ($res) {
            $this->returnJson(0,'');
        } else {
            $this->returnJson(10010,'');
        }
    }



}

