<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 输出json
     * @param int $errcode 状态码
     * @param string $msg
     * @return json
     */
    public function returnJson($errcode = 0, $msg = '')
    {
        $data['errcode'] = $errcode;
        $data['msg'] = $msg;
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
