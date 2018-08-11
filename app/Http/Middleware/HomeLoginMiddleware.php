<?php

namespace App\Http\Middleware;

use Closure;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use App\Models\WxUser;
use Exception;

class HomeLoginMiddleware
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session('uid')) {
            return $next($request);
        } else {
            //未登录
            $app = Factory::officialAccount(config('wechat'));
            $oauth = $app->oauth;
            try {
                $appInfo = $oauth->user();
                $userInfo = $appInfo->original;
                $user = new WxUser;
                $res = $user::where('openid', $userInfo['openid'])->first();
                if (!$res) {
                    $user->nickname = $userInfo['nickname'];
                    $user->avatar = $userInfo['headimgurl'];
                    $user->sex = $userInfo['sex'];
                    $user->openid = $userInfo['openid'];
                    $user->save();
                    $uid = $user->id;
                } else {
                    $uid = $res->id;
                }
                session(['uid'=>$uid]);
                return $next($request);
            } catch (Exception $e) {
                $response = $oauth->redirect($request->fullUrl());
                return $response;
            }
        }
    }
}
