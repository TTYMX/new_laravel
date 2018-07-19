<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Order extends Model
{
    protected $table = 'lh_orders';
    protected $primaryKey = 'id';

    public function __construct()
    {
        echo '暂时不用model';die;
    }

    public function select($name)
    {
        return DB::table($this->table)->where('username',$name)->first();
    }

    public function find($id)
    {
        return DB::table($this->table)->where('id',$id)->first();
    }
}