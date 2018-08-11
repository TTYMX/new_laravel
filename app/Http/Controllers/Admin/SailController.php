<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sail;
use Log;
use App\Exports\SailsExport;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Exporter;

class SailController extends Controller
{
    private $excel;

    public function __construct(Excel $excel,Exporter $exporter)
    {
        $this->excel = $excel;
        $this->exporter = $exporter;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sail(Request $request)
    {
        $res = Sail::select('created_at','name','id','num')
            ->orderBy('created_at','DESC')
            ->paginate(20);
        $result=$res->toArray()['data'];
        $sail = array();
        foreach ($result as $k=>$v) {
            $sail[$v['created_at']][] = $v;
        }
        $list = $request->all();
        return view('admin/sail/sail',['sail'=>$sail,'list' => $list,'res'=>$res]);
    }

    public function excel(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        return $this->excel->download(new SailsExport($start,$end), 'sails'.date('Y-m-d H:i:s',time()).'.xlsx');
    }



}
