<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Good;
use DB;


class CommentController extends Controller
{
    public function add(Request $request)
    {
        $goodId = $request->input('id');


    }

    //$message = new Message;
    //         $message->user_id = session('uid');
    //         $message->good_id = $goodId;
    //         $message
}

