<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pic extends Model
{
    protected $table = 'lh_pics';
    protected $primaryKey = 'id';
    protected $dateFormat = 'U';
}