<?php

namespace App\Http\Middleware;

use Closure;

class HomeLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //通过session来检测用户是否登录
        if(session('uid')){
            //进入下一层请求
            return $next($request);
        }else{
            return redirect('/home/login/login')->with('error','您还没有登录');
        }
    }
}
