<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;

class Testcontroller extends Controller
{
    public function __construct(\Maatwebsite\Excel\Excel $excel)
    {
        $this->excel = $excel;
        return $this->excel->export(new Export);
    }

    public function export(Request $request)
    {

    }

    public function test()
    {

    }
}