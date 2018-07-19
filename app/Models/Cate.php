<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cate extends Model
{
    protected $dateFormat = 'U';
    protected $table = 'lh_cates';
    protected $primaryKey = 'id';
}