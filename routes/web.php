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

Route::get('/', 'Home\IndexController@index');


/**
 * 后台  统一中间件
 */
Route::middleware(['AdminLogin'])->prefix('admin/')->group( function () {
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
});

Route::get('/admin/login', 'Admin\LoginController@index');
Route::post('/login/adminCheck', 'Admin\LoginController@checkLogin');