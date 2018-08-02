<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
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

    public function getAccessToken(Request $request)
    {
        $code = $request->input('code');
        $state = $request->input('state');
        $appid = $this->appid;
        $appsecret = $this->appsecret;
        if (empty($code)) $this->error('授权失败');
        $token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$appsecret.'&code='.$code.'&grant_type=authorization_code';
        $token = json_decode(file_get_contents($token_url));
        if (isset($token->errcode)) {
            echo '<h1>错误：</h1>'.$token->errcode;
            echo '<br/><h2>错误信息：</h2>'.$token->errmsg;
            exit;
        }
        $access_token_url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$appid.'&grant_type=refresh_token&refresh_token='.$token->refresh_token;
        //转成对象
        $access_token = json_decode(file_get_contents($access_token_url));
        if (isset($access_token->errcode)) {
            echo '<h1>错误：</h1>'.$access_token->errcode;
            echo '<br/><h2>错误信息：</h2>'.$access_token->errmsg;
            exit;
        }
    }
}
