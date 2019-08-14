<?php

namespace App\Jobs\Api\V1\Payment;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use EasyWeChat\Factory;

class PreOrderJob
{
    use Dispatchable, Queueable;

    private $app;
    private $payment_count;
    private $info;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->app = Factory::payment(config('wechat.payment.default'));
        $this->payment_count = $params['payment_count'];
        $this->info = $params['info'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order_num = date("ymd") . substr(time(), -5) . substr(microtime(), 2, 5);
        //元换成分
        $payment_count = bcmul($this->payment_count, 100);

        TableModels\PayLog::create([
            'appid' => config('wechat.payment.default.app_id'),
            'mch_id' => config('wechat.payment.default.mch_id'),
            'out_trade_no' => $order_num,
            'info' => $info,
        ]);

        $result = $this->app->order->unify([
            'trade_type' => 'JSAPI',
            'body' => '车辆定金',
            'out_trade_no' => $order_num,
            'total_fee' => $payment_count,
        ]);

        if ($result['result_code'] == 'SUCCESS') {
            $response = [
                'code' => 200,
                'msg' => 'success',
                'order_num' => $order_num,
                'data' => $result,
            ];
        }
    }
}
