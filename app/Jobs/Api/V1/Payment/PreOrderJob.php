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

    private $app;
    //支付金额元
    private $payment_count;
    // 用户ID
    private $customer_id;
    private $shop_id;
    private $car_id;
    // type == 1 购买车  || type==2 商城充值 || type==3 商场微信支付
    private $type;
    //配件ID
    private $mall_accessory_id;
    //收货地址ID
    private $mall_address_id;
    private $mall_accessory_count;
    private $mall_accessory_detail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->app = Factory::payment(config('wechat.payment.default'));
        $this->type = isset($params['type']) ? $params['type'] : 1;
        $this->payment_count = $params['payment_count'];
        $this->customer_id = $params['customer_id'];
        $this->car_id = isset($params['car_id']) ? $params['car_id'] : null;
        $this->shop_id = isset($params['shop_id']) ? $params['shop_id'] : null;
        $this->mall_accessory_id = isset($params['mall_accessory_id']) ? $params['mall_accessory_id'] : null;
        $this->mall_accessory_count = isset($params['mall_accessory_count']) ? $params['mall_accessory_count'] : 1;
        $this->mall_address_id = isset($params['mall_address_id']) ? $params['mall_address_id'] : 0;
        $this->mall_accessory_detail = isset($params['mall_accessory_detail']) ? json_encode($params['mall_accessory_detail']) : '';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //购买车 未走微信支付流程
        if ($this->type == 1) {
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
                            $car->group_num += 1;
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
        }

        // 积分充值
        if ($this->type == 2) {

            $customer = TableModels\Customer::find($this->customer_id);
            if (is_null($customer)) {
                $response = [
                    'code' => trans('pheicloud.response.notExist.code'),
                    'msg' => trans('pheicloud.response.notExist.msg'),
                ];
                return response()->json($response);
            }

            $order_num = date("ymd") . substr(time(), -5) . substr(microtime(), 2, 5);
            //元换成分
            $payment_count = bcmul($this->payment_count, 100);

            $info = [
                'type' => $this->type,
                'customer_id' => $this->customer_id,
            ];

            TableModels\PayLog::insert([
                'appid' => config('wechat.payment.default.app_id'),
                'mch_id' => config('wechat.payment.default.mch_id'),
                'out_trade_no' => $order_num,
                'info' => json_encode($info),
                'type' => $this->type,
            ]);

            $result = $this->app->order->unify([
                'trade_type' => 'JSAPI',
                'body' => '积分充值',
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
        }
        
        // 微信购买商城物品
        if ($this->type == 3) {
            $customer = TableModels\Customer::find($this->customer_id);
            if (is_null($customer)) {
                $response = [
                    'code' => trans('pheicloud.response.notExist.code'),
                    'msg' => trans('pheicloud.response.notExist.msg'),
                ];
                return response()->json($response);
            }
            $order_num = date("ymd") . substr(time(), -5) . substr(microtime(), 2, 5);
            //元换成分
            $payment_count = bcmul($this->payment_count, 100);
            $info = [
                'type' => $this->type,
                'customer_id' => $this->customer_id,
                'mall_accessory_id' => $this->mall_accessory_id,
                'mall_accessory_count' => $this->mall_accessory_count,
                'mall_address_id' => $this->mall_address_id,
                'mall_accessory_detail' => $this->mall_accessory_detail,
            ];
            //统一订单列表
            TableModels\PayLog::insert([
                'appid' => config('wechat.payment.default.app_id'),
                'mch_id' => config('wechat.payment.default.mch_id'),
                'out_trade_no' => $order_num,
                'info' => json_encode($info),
                'type' => $this->type,
            ]);
            // 创建订单
            TableModels\MallAccessoryOrder::insert([
                'customer_id' => $this->customer_id,
                'mall_accessory_id' => $this->mall_accessory_id,
                'mall_address_id' => $this->mall_address_id,
                'status' => 1,
                'pay_type' => 1,
                'pay_price' => $this->payment_count,
                'uuid' => $order_num,
            ]);
            $result = $this->app->order->unify([
                'trade_type' => 'JSAPI',
                'body' => '商城商品',
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
