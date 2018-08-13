<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use zgldh\QiniuStorage\QiniuStorage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        // 判断是否有文件上传
        if ($request->hasFile('file')) {
            // 获取文件,file对应的是前端表单上传input的name
            $file = $request->file('file');
            $allowed_extensions = ["png", "jpg", "gif"];
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                return response()->json([
                    'status' => false,
                    'message' => '只能上传 png | jpg | gif格式的图片'
                ]);
            }

            // $destinationPath = './uploads/ping/';
            // if (!file_exists('./uploads/ping/')) {
            //     mkdir('./uploads/ping/');
            // }
            // $extension = $file->getClientOriginalExtension();
            // $fileName = str_random(10).'.'.$extension;
            // $res_move = $file->move($destinationPath, $fileName);
            // $id = $request->id;
            // $orderInfo = Order::find($id);
            // $res_un = '';
            // if (file_exists('./uploads/ping/'.$orderInfo['comment_pic'])) {
            //     $res_un = unlink('./uploads/ping/'.$orderInfo['comment_pic']);
            // }
            //
            // $res = Order::where('id',$id)->update(['comment_pic'=>$fileName]);
            // if ($res && $id && $res_move) {
            //
            //     $this->returnJson(0,'/uploads/ping/'.$fileName);
            // } else {
            //     $this->returnJson(10010,'上传失败');
            // }
            // var_dump($res_un);
            // die;
            // $file = $request->file;
            // 初始化
            $disk = QiniuStorage::disk('qiniu');
            // 重命名文件
            $fileName = md5($file->getClientOriginalName() . time() . rand()) . '.' . $file->getClientOriginalExtension();
            // 上传到七牛
            $bool = $disk->put('ping/image_' . $fileName, file_get_contents($file->getRealPath()));
            $id = $request->id;
            // 判断是否上传成功
            if ($bool && $id) {
                $path = $disk->downloadUrl('ping/image_' . $fileName);
                $res = Order::where('id',$id)->update(['comment_pic'=>$path]);
                $this->returnJson(0,$path);
            }
            $this->returnJson(10010,'上传失败');
        }
        $this->returnJson(10010,'没有文件');
    }
}
