<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//首页
Route::get('/', 'Home\IndexController@index');
Route::get('/home/index/detail','Home\IndexController@detail');
Route::get('/home/login/login','Home\LoginController@login');

Route::middleware(['HomeLogin'])->prefix('home/')->group(function () {
    Route::get('card/card', 'Home\CardController@card');
    Route::get('card/delete', 'Home\CardController@delete');
    Route::get('card/buy', 'Home\CardController@buy');
    Route::get('card/card', 'Home\CardController@card');
    Route::get('card/list', 'Home\CardController@list');
});
/**
 * 后台  统一中间件
 */
Route::middleware(['AdminLogin'])->prefix('admin/')->group(function () {
    //后台首页
    Route::get('index', 'Admin\IndexController@index');
    //退出后台登录
    Route::get('login/logout', 'Admin\LoginController@logout');
    //后台用户管理
    Route::get('user/index', 'Admin\UserController@index');
    Route::get('user/add', 'Admin\UserController@add');
    Route::post('user/insert', 'Admin\UserController@insert');
    Route::get('user/edit', 'Admin\UserController@edit');
    Route::post('user/update', 'Admin\UserController@update');
    Route::post('user/delete', 'Admin\UserController@delete');
    //分类处理
    Route::get('cate/add', 'Admin\CateController@add');
    Route::get('cate/index', 'Admin\CateController@index');
    Route::get('cate/edit', 'Admin\CateController@edit');
    Route::post('cate/update', 'Admin\CateController@update');
    Route::post('cate/insert', 'Admin\CateController@insert');
    Route::post('cate/delete', 'Admin\CateController@delete');
    //商品处理
    Route::get('goods/add', 'Admin\GoodsController@add');
    Route::get('goods/index', 'Admin\GoodsController@index');
    Route::get('goods/edit', 'Admin\GoodsController@edit');
    Route::post('goods/update', 'Admin\GoodsController@update');
    Route::post('goods/insert', 'Admin\GoodsController@insert');
    Route::post('goods/delete', 'Admin\GoodsController@delete');
    Route::post('goods/updateStatus', 'Admin\GoodsController@updateStatus');

    //订单管理
    Route::get('orders/index', 'Admin\OrdersController@index');

});
//后台的登录
Route::get('/admin/login', 'Admin\LoginController@index');
Route::post('/login/adminCheck', 'Admin\LoginController@checkLogin');

//excel测试
Route::get('/admin/test', 'Admin\TestController@test');
Route::get('/admin/export', 'Admin\TestController@export');
