<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Good;
use App\Models\Card;
use session;
use DB;


class CardController extends Controller
{
    /**
     * 加入购物车
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function card(Request $request)
    {
        $goodId = (int)$request->input('id');
        $goodInfo = Good::where('id', $goodId)->first();
        if ($goodInfo->total < 1) {
            echo '卖完了,别捣乱';
            exit;
        }
        $userId = session('uid');
        $orderInfo = Card::where('good_id', $goodId)->where('user_id', $userId)->first();
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
            return view('home/card/success');
        } else {
            DB::rollback();
            return view('home/card/success');
        }
    }

    /**
     * 删除购物车购物
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $res = Card::where('id', $id)->delete();
        if ($res) {
            $this->returnJson(0,'success');
        }
        $this->returnJson(10010,'success');
    }

    /**
     * 购物车列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request)
    {
        $cards = Card::selectRaw('lh_cards.*,lh_pics.path')
            ->where('user_id',session('uid'))
            ->leftJoin('lh_pics', 'lh_cards.good_id', '=', 'lh_pics.good_id')
            ->get();
        if ($request->ajax()) {
            $this->returnJson(0,$cards);
        } else {
            return view('home/card/card', ['cards' => $cards]);
        }
    }


}

