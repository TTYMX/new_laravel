<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserModel extends Model
{
    protected $table = 'lh_users';
    protected $primaryKey = 'id';

    public function __construct()
    {
        //echo '暂时不用model';
    }

    public function select($name)
    {
        return DB::table('users')->where('username',$name)->first();
    }

    public function find($id)
    {
        return DB::table('users')->where('id',$id)->first();
    }
}