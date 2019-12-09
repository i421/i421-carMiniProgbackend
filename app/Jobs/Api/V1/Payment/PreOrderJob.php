<?php

namespace App\Jobs\Api\V1\Payment;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use EasyWeChat\Factory;
use function EasyWeChat\Kernel\Support\generate_sign;

class PreOrderJob
{
    use Dispatchable, Queueable;

    //private $app;
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
        //$this->app = Factory::payment(config('wechat.payment.default'));
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
        $count = TableModels\OrderMessage::where([
            ['created_at', '>=', date("Y-m-d 00:00:00")],
            ['customer_id', '=', $this->customer_id],
        ])->count();

        if ($count > 3) {

            $response = [
                'code' => trans('pheicloud.response.orderOutOfRange.code'),
                'msg' => trans('pheicloud.response.orderOutOfRange.msg'),
            ];

            return response()->json($response);
        }

        $customer = TableModels\Customer::find($this->customer_id);

        if (is_null($customer)) {

            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);
        }

        if ($customer->auth == 0) {

            $response = [
                'code' => trans('pheicloud.response.notAuth.code'),
                'msg' => trans('pheicloud.response.notAuth.msg'),
            ];

            return response()->json($response);
        }

        $order_num = date("ymd") . substr(time(), -5) . substr(microtime(), 2, 5);
        //元换成分
        $payment_count = bcmul($this->payment_count, 100);

        //支付成功: 销售量+1 || 拼团数量当前+1
        $car = TableModels\Car::find($this->car_id);

        if (!is_null($car)) {
            if ($car->type == 1) {
                $car->sale_num += 1;
                $car->save();
            } else {
                $current_num = $car->current_num;
                if ($car->group_type == 2) {
                    if (($current_num + 1) > $car->total_num) {
                        $car->current_num += 1;
                        $car->sale_num += 1;
                        $car->group_type += 1;
                        $car->save();
                    } else {
                        $car->current_num += 1;
                        $car->sale_num += 1;
                        $car->save();
                    }
                } else {
                    $car->current_num += 1;
                    $car->sale_num += 1;
                    $car->save();
                }
            }
        }

        /*
        if (!is_null($car)) {
            if ($car->type == 1) {
                $car->sale_num += 1;
                $car->save();
            } else {
                $current_num = $car->current_num;
                if ($car->group_type == 2) {
                    if ($current_num < $car->total_num) {
                        $car->current_num += 1;
                        $car->sale_num += 1;
                        $car->save();
                    } else {
                        $response = [
                            'code' => trans('pheicloud.response.groupOutOfRange.code'),
                            'msg' => trans('pheicloud.response.groupOutOfRange.msg'),
                        ];
                        return response()->json($response);
                    }
                } else {
                    $car->current_num += 1;
                    $car->sale_num += 1;
                    $car->save();
                }
            }
        }
         */

        $res = TableModels\Order::create([
            'order_num' => $order_num,
            'car_id' => $this->car_id,
            'customer_id' => $this->customer_id,
            'shop_id' => $this->shop_id,
            'payment_count' => $payment_count,
            'pay_log_id' => 0,
            'payment_status' => 1,
        ]);

        // 创建订单支付成功通知信息
        TableModels\OrderMessage::insert([
            'customer_id' => $this->customer_id,
            'content' => '您的订单支付成功',
            'order_num' => $order_num,
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

		// 以下为微信支付，因审核不通过暂时移除该功能
		/*
        $info = [
            'car_id' => $this->car_id,
            'customer_id' => $this->customer_id,
            'shop_id' => $this->shop_id,
        ];

        TableModels\PayLog::insert([
            'appid' => config('wechat.payment.default.app_id'),
            'mch_id' => config('wechat.payment.default.mch_id'),
            'out_trade_no' => $order_num,
            'info' => json_encode($info);
        ]);

        $result = $this->app->order->unify([
            'trade_type' => 'JSAPI',
            'body' => '车辆定金',
            'out_trade_no' => $order_num,
            'total_fee' => $payment_count,
            'openid' => $customer->openid,
        ]);

        if ($result['result_code'] == 'SUCCESS') {

            $params = [
                'appId' => config('wechat.mini_program.default.app_id'),
                'timeStamp' => time(),
                'nonceStr'  => $result['nonce_str'],
                'package'   => 'prepay_id=' . $result['prepay_id'],
                'signType'  => 'MD5',
            ];

            $params['paySign'] = generate_sign($params, config('wechat.payment.default.key'));

            $response = [
                'code' => trans('pheicloud.response.success.code'),
                'msg' => trans('pheicloud.response.success.msg'),
                'data' => [
                    'result' => $params,
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
