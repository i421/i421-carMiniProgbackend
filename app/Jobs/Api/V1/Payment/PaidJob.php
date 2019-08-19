<?php

namespace App\Jobs\Api\V1\Payment;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use EasyWeChat\Factory;

class PaidJob
{
    use Dispatchable, Queueable;

    private $out_trade_no;
    private $app;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $out_trade_no)
    {
        $this->out_trade_no = $out_trade_no;
        $this->app = Factory::payment(config('wechat.payment.default'));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $res = $this->app->order->queryByOutTradeNumber($this->out_trade_no);

        if ($res['trade_state'] === 'SUCCESS') {
            $code = '200';
            $msg = 'paid';
        } else {
            $code = '202';
            $msg = 'not paid';

        }

        $response = [
            'code' => $code,
            'msg' => $msg,
        ];

        return response()->json($response);
    }
}
