<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\WxUser;
use App\Jobs\SendMsg;
use Log;

class OrdersController extends Controller
{

    /**
     * 登录页面
     */
    public function index(Request $request)
    {
        $num = $request->input('num', 5);
        $orders = Order::selectRaw("lh_orders.*,lh_wx_users.nickname as username")
            ->leftJoin('lh_wx_users', 'lh_orders.user_id', '=', 'lh_wx_users.id')
            ->orderBy('lh_orders.created_at','DESC')
            ->paginate($num);
        $list = $request->all();
        return view('admin/order/index', ['orders' => $orders, 'list' => $list]);
    }

    public function edit(Request $request)
    {
        $id = (int)$request->input('id');
        $orderInfo = Order::find($id);
        $userInfo = WxUser::find($orderInfo->user_id);
        $res = Order::where('id', $id)->update(['status' => 2]);
        //执行队列
        Log::info('send_msg进入队列');
        SendMsg::dispatch($userInfo->openid, $userInfo->nickname)->onQueue('send_msg');
        $res ? $this->returnJson(0, '') : $this->returnJson(10010, '');
    }


}
