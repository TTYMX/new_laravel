<?php

namespace App\Libraries\Wechat;

class Test
{
    public $test = 3;

    public static function say()
    {
        return '这个是library的方法';
    }

    public function do()
    {
        return '这不是一个静态方法';
    }
}