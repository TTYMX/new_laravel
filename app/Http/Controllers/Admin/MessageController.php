<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {

        //获取被评论商品id和名字
        $goods = DB::table('comment')->select('goods.name','goods.id')
            ->join('goods','goods.id','=','comment.gid')
            ->get();
        // dd($goods);
        //对象串行化为了消除重复
        foreach($goods as $k=>$v){
            $row[]= serialize($v);
        }
        $goods = array_unique($row);
        unset($row);
        //反串行化
        foreach($goods as $k=>$v){
            $row[] = unserialize($v);
        }
        $goods = $row;

        foreach($goods as $k=>$v){
            $comment[$k] = DB::table('comment')->select('comment.*','users.username','goods.name')
                ->join('users','users.id','=','comment.uid')
                ->where('gid','=',$v->id)
                ->join('goods','goods.id','=','comment.gid')
                ->get();
        }
        return view('/admin/comment/index',['comment'=>$comment,'goods'=>$goods]);
    }


    public function getHuifu(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        $data['htime'] = date('Y-m-d H:i:s');
        // dd($data);
        $res = DB::table('comment')->where('id','=',$data['id'])->update(['scomt'=>$data['scomt'],'htime'=>$data['htime']]);
        if($res){
            //成功 到列表页
            return redirect('/admin/comment/index')->with('success','回复成功');
        }else{
            return back()->with('error','回复失败');
        }
    }


    public function getDelete(Request $request)
    {
        // dd($request->all());
        $id = $request->input('id');

        $res = DB::table('comment')->where('id','=',$id)->delete();
        if($res){
            //成功 到列表页
            return redirect('/admin/comment/index')->with('success','删除评论成功');
        }else{
            return back()->with('error','删除评论失败');
        }
    }
}
