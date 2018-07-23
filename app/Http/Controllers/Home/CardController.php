<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Good;
use App\Models\Card;
use Illuminate\Support\Facades\DB;


class CardController extends Controller
{
    /**
     * 加入购物车
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function card(Request $request)
    {
        $goodId = (int)$request->input('good_id');
        $goodInfo = Good::select()->where('id', $goodId)->first();
        if ($goodInfo->total < 1) {
            echo '卖完了,别捣乱';
            exit;
        }
        $userId = session('uid');
        $orderInfo = Card::select()->where('good_id', $goodId)->where('user_id', $userId)->first();
        DB::beginTransaction();
        if (!$orderInfo) {
            $card = new Card;
            $card->good_id = $goodInfo->id;
            $card->user_id = $userId;
            $card->price = $goodInfo->price;
            $card->name = $goodInfo->name;
            $card->num = 1;
            $resCard = $card->save();
        } else {
            $data['num'] = $orderInfo->num + 1;
            $data['price'] = $orderInfo->price + $goodInfo->price;
            $resCard = Card::where('good_id', $goodId)->where('user_id', $userId)->update($data);
        }
        $resGood = Good::where('id', $goodId)->update(['total' => $goodInfo->total - 1]);
        if ($resGood && $resCard) {
            DB::commit();
            $this->returnJson(0,'添加成功');
        } else {
            DB::rollback();
            $this->returnJson(10010,'添加失败');
        }
    }

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
        $order->user_id = session('uid');
        DB::beginTransaction();
        $resOrder = $order->save();
        $resGood = Good::where('id', $id)->update(['total' => $goodInfo->total - 1]);
        if ($resOrder && $resGood) {
            DB::commit();
            return redirect(url('/home/index/detail?id='.$id))->with('success','购买成功');
        } else {
            DB::rollback();
            return redirect(url('/home/index/detail?id='.$id))->with('error','购买失败');
        }
    }

    public function delete(Request $request)
    {
        $id = $this->input('id');
        $res = Card::where('id', $id)->delete();
        if ($res) {
            redirect(url('/'));
        }
    }

    /**
     *
     */
    public function list(Request $request)
    {
        $cards = Card::selectRaw('lh_cards.*,lh_pics.path')
            ->where('user_id',session('uid'))
            ->leftJoin('lh_pics','lh_cards.good_id', '=', 'lh_pics.good_id')
            ->get();
        return view('home/card/card',['cards'=>$cards]);
    }
}

