<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Good extends Model
{
    protected $dateFormat = 'U';
    protected $table = 'lh_goods';
    protected $primaryKey = 'id';
}