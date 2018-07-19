<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cate extends Model
{
    protected $table = 'lh_cates';
    protected $primaryKey = 'id';

    public function select($keywords,$num)
    {
        $cates = DB::table('lh_cates')
            ->where('name', 'like', '%' . $keywords . '%')
            ->select(DB::raw("*,concat(path,',',id) as paths"))
            ->orderBy('paths')
            ->paginate($num);
        echo '<pre>';
        var_dump($cates);
        return $cates;
    }

}