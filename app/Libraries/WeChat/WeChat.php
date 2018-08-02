<?php

namespace App\Libraries\Wechat;

use EasyWeChat\Factory;

class WeChat
{
    public static function login()
    {
        $config = [
            'oauth' => [
                'scopes' => ['snsapi_userinfo'],
                'callback' => '/',
            ],
        ];
        $app = Factory::officialAccount($config);
        $oauth = $app->oauth;

        var_dump($oauth);
        die;
        $user = $oauth->user();
        echo '<pre>';
        var_dump($user);
        die;
        //https://open.weixin.qq.com/connect/oauth2/authorize?
        //redirect_uri=http%3A%2F%2Fmengxianfan.training.hsh.lehuipay.com%2F&
        //response_type=code&scope=snsapi_userinfo&
        //state=33fd974ff71c0a9bb7e1c219e699246a#wechat_redirect
        var_dump($request->session()->get('wechat_user'));
        die;
        echo 'mengxian';
        echo '<br>';
        var_dump($user);
        echo '<br>';
        var_dump($oauth);
        die;

        if (empty($_SESSION['wechat_user'])) {
            $_SESSION['target_url'] = 'user/profile';
            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        }
        $user = $_SESSION['wechat_user'];
    }
}