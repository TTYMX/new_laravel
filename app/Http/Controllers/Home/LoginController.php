<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WxUser;
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
     * @param Request $request
     * @param Closure $next
     */
    public function login(Request $request)
    {
        echo 'login';die;
    }

    public function vue(Request $request)
    {
        return view('home/index/index');
    }


}
