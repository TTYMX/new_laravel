<?php

namespace App\Jobs;

use App\Podcast;
use App\AudioProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use EasyWeChat\Factory;
use Log;

class SendMsg implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $openid;
    protected $nickname;
    public $tries = 5;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($openid='', $nickname='')
    {
        $this->openid = $openid;
        $this->nickname = $nickname;
        Log::info('send_msg 实例化');
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('send_msg执行');
        $app = Factory::officialAccount(config('wechat'));
        $app->template_message->send([
            'touser' => $this->openid,
            'template_id' => config('wechat.template_id'),
            'url' => 'http://mengxianfan.training.hsh.lehuipay.com',
            'data' => [
                'v1' => $this->nickname,
            ],
        ]);
    }
}
