<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrdersController extends Controller
{

    /**
     * 登录页面
     */
    public function index(Request $request)
    {
        $num = $request->input('num', 5);
        $orders = Order::selectRaw("lh_orders.*,lh_users.username as username")
            ->leftJoin('lh_users','lh_orders.user_id', '=', 'lh_users.id')
            ->paginate($num);
        $list = $request->all();
        return view('admin/order/index',['orders'=>$orders,'list'=>$list]);
    }

}