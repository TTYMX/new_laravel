<?php

namespace App\Services;

use App\Models\UserModel as userModel;

/**
 * Class User   用户信息的service
 * @package App\Services
 */
class UserService
{
    /**
     * User constructor.  构造器
     */
    public function __construct()
    {
        //暂时不用
    }

    public function select($name)
    {
        $userModel = new userModel;
        return $userModel->select($name);
    }
}