<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Order extends Model
{
    protected $table = 'lh_orders';
    protected $primaryKey = 'id';
    protected $dateFormat = 'U';
}