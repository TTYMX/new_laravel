<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;


class IndexController extends Controller
{
    /**
     * 首页显示的数据
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        echo '首页 暂时不做';die;
        $categories = Category::query()->orderBy('parent_id', 'desc')->take(9)->get();
        $hotProducts = Product::query()->orderBy('safe_count', 'desc')->take(3)->get();
        $latestProducts = Product::query()->latest()->take(9)->get();
        $users = User::query()->orderBy('login_count', 'desc')->take(10)->get(['name', 'avatar']);

        return view('home.home.index', compact('categories', 'hotProducts', 'latestProducts', 'users'));
    }
}

