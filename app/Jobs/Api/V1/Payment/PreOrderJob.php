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
    private $customer_id;
    private $shop_id;
    private $car_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->app = Factory::payment(config('wechat.payment.default'));
        $this->payment_count = $params['payment_count'];
	$this->customer_id = $params['customer_id'];
	$this->car_id = $params['car_id'];
	$this->shop_id = $params['shop_id'];
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

        // test begin
        $res = TableModels\Order::create([
            'order_num' => $order_num,
            'customer_id' => $this->info['customer_id'],
            'car_id' => $this->info['car_id'],
            'shop_id' => $this->info['shop_id'],
            'payment_count' => $payment_count,
            'pay_log_id' => 1,
            'payment_status' => 1,
        ]);

        if ($res) {
             $response = [
                 'code' => trans('pheicloud.response.success.code'),
                 'msg' => trans('pheicloud.response.success.msg'),
             ];
             return response()->json($response);
        } else {
             $response = [
                 'code' => trans('pheicloud.response.error.code'),
                 'msg' => trans('pheicloud.response.error.msg'),
             ];
             return response()->json($response);
        }
        // Test end

        /*
        TableModels\PayLog::create([
            'appid' => config('wechat.payment.default.app_id'),
            'mch_id' => config('wechat.payment.default.mch_id'),
            'out_trade_no' => $order_num,
	    'info' => [
		'car_id' => $this->car_id,
	    	'customer_id' => $this->customer_id,
	    	'shop_id' => $this->shop_id,
	    ],
        ]);

        $result = $this->app->order->unify([
            'trade_type' => 'JSAPI',
            'body' => '车辆定金',
            'out_trade_no' => $order_num,
            'total_fee' => $payment_count,
        ]);

        if ($result['result_code'] == 'SUCCESS') {
            $response = [
                'code' => trans('pheicloud.response.success.code'),
                'msg' => trans('pheicloud.response.success.msg'),
                'data' => [
                    'result' => $result,
                    'order_num' => $order_num,
                ]
            ];

            return response()->json($response);
        } else {
            $response = [
                'code' => trans('pheicloud.response.requestPayError.code'),
                'msg' => trans('pheicloud.response.requestPayError.msg'),
                'data' => []
            ];

            return response()->json($response);
        }
         */
    }
}
