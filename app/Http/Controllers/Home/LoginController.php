<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Active;
use EasyWeChat\Factory;
use EasyWeChat\Foundation\Application;

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
        //$app = Factory::officialAccount(config('wechat'));
        //$user = $app->user;
      
        $app = new Application(config('wechat'));
        $user = $app->oauth->user();
    }


}
