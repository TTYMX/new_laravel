<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Models\Order;
use App\Models\Sail;
use DB;

class CountDay extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'CountDay';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'every day sale data';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        Log::info('test  insert');
        $res = Order::selectRaw('good_id,count(lh_orders.id) num,lh_goods.name')
            ->leftJoin('lh_goods', 'lh_orders.good_id', '=', 'lh_goods.id')
            ->groupBy('good_id')
            ->get()
            ->toArray();
        Sail::insert($res);
    }
}
