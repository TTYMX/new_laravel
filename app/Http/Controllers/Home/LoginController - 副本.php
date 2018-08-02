<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Active;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Redis;



define("TOKEN", "xianfan");

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     * @var string
     */
    protected $redirectTo = '/';

    protected $appid = 'wx8cb58549d7d11068';
    protected $appsecret = '9b3edf4f072e5c0b6aebebbdb7d407db';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {

    }
    public function login(Request $request)
    {
        $app = Factory::officialAccount(config('wechat'));

        $app->oauth->user();
        die;
        $user = $app->user;
        echo '<hr>';
        $server = $app->server;


        $server->push(function($message) use ($user) {
            $fromUser = $user->get($message['FromUserName']);

            return "{$fromUser->nickname} 您好！欢迎关注 overtrue!";
        });

        echo '<pre>';
        var_dump($user);
        var_dump($server);
        die;












        die;
        $config = [
            'oauth' => [
                'scopes'   => ['snsapi_userinfo'],
                'callback' => '/',
            ],
        ];

        $app = Factory::officialAccount($config);
        $oauth = $app->oauth;
        $user = $oauth->user();
        echo '<pre>';
        var_dump($user);die;
        //https://open.weixin.qq.com/connect/oauth2/authorize?
        //redirect_uri=http%3A%2F%2Fmengxianfan.training.hsh.lehuipay.com%2F&
        //response_type=code&scope=snsapi_userinfo&
        //state=33fd974ff71c0a9bb7e1c219e699246a#wechat_redirect
        var_dump($request->session()->get('wechat_user'));die;
        echo 'mengxian';echo '<br>';
        var_dump($user);echo '<br>';
        var_dump($oauth);die;

        if (empty($_SESSION['wechat_user'])) {
            $_SESSION['target_url'] = 'user/profile';
            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        }
        $user = $_SESSION['wechat_user'];
    }

    // public function login()
    // {
    //     $appid = $this->appid;
    //     $uri = 'http://mengxianfan.training.hsh.lehuipay.com/home/login/user';
    //     $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$uri&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
    //     header('location:' . $url);
    // }

    public function user(Request $request)
    {
        $code = $request->input('code');
        $state = $request->input('state');
        $appid = $this->appid;
        $appsecret = $this->appsecret;
        if (empty($code)) $this->error('授权失败');
        $token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $appsecret . '&code=' . $code . '&grant_type=authorization_code';
        $token = json_decode(file_get_contents($token_url));
        if (isset($token->errcode)) {
            echo '<h1>错误：</h1>' . $token->errcode;
            echo '<br/><h2>错误信息：</h2>' . $token->errmsg;
            exit;
        }
        if (!Redis::exists('test_access_token')) {
            $access_token_url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=' . $appid . '&grant_type=refresh_token&refresh_token=' . $token->refresh_token;
            //转成对象
            $access_token = file_get_contents($access_token_url);
            Redis::setex('test_access_token',7100,$access_token);
            if (isset($access_token->errcode)) {
                echo '<h1>错误：</h1>' . $access_token->errcode;
                echo '<br/><h2>错误信息：</h2>' . $access_token->errmsg;
                exit;
            }
        }
        $access_token = json_decode(Redis::get('test_access_token'));
        var_dump($access_token);
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo $access_token->access_token;
        echo '<br>';
        echo '<br>';
        echo $access_token->openid;
        $user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token->access_token . '&openid=' . $access_token->openid . '&lang=zh_CN';
        echo '<br>';
        $user_info = json_decode(file_get_contents($user_info_url));
        var_dump($user_info);
        die;
        $user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token->access_token . '&openid=' . $access_token->openid . '&lang=zh_CN';
        //转成对象
        $user_info = json_decode(file_get_contents($user_info_url));
        if (isset($user_info->errcode)) {
            echo '<h1>错误：</h1>' . $user_info->errcode;
            echo '<br/><h2>错误信息：</h2>' . $user_info->errmsg;
            exit;
        }
        echo '<pre>';
        var_dump($access_token);
        dd($user_info);
        $active = new Active;
        $active->nickname = json_encode($user_info->nickname);
        $active->sex = $user_info->sex;
        $active->openid = $user_info->openid;
        $active->headimgurl = $user_info->headimgurl;
        $res = Active::where('openid', $user_info->openid)->first();
        $res ? '' : $active->save();
        session(['openid' => $active->openid]);
    }
}
