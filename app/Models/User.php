<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class User extends Model
{
    protected $table = 'lh_users';
    protected $primaryKey = 'id';
}