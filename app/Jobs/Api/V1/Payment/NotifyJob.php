<?php

namespace App\Jobs\Api\V1\Payment;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use EasyWeChat\Factory;

class NotifyJob
{
    use Dispatchable, Queueable;

    private $app;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->app = Factory::payment(config('wechat.payment.default'));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = $this->app->handlePaidNotify(function($message, $fail) {

            $order = TableModels\Order::where('order_num', $message['out_trade_no'])->first();
            if ($order) {
                // 已经生成订单表示已经处理完成，告诉微信不用再通知了
                return true;
            }

            //查看支付日志
            $payLog = TableModels\PayLog::where('out_trade_no', $message['out_trade_no'])->first();

            if (!$payLog || $payLog->paid_at) {
                //订单不存在或者已经支付过，告诉微信别通知
                return true;
            }

            if ($message['return_code'] === 'SUCCESS') {
                //用户是否支付成功
                if ($message['result_code'] === 'SUCCESS') {

                    //完善预下单信息, 更新支付时间为当前时间
                    TableModels\PayLog::where('out_trade_no', $message['out_trade_no'])->update([
                        'appid' => $message['appid'],
                        'bank_type' => $message['bank_type'],
                        'total_fee' => $message['total_fee'],
                        'trade_type' => $message['trade_type'],
                        'is_subscribe' => $message['is_subscribe'],
                        'mch_id' => $message['mch_id'],
                        'nonce_str' => $message['nonce_str'],
                        'openid' => $message['openid'],
                        'sign' => $message['sign'],
                        'cash_fee' => $message['cash_fee'],
                        'fee_type' => $message['fee_type'],
                        'transaction_id' => $message['transaction_id'],
                        'time_end' => date("Y-m-d H:i:s"),
                        'result_code' => $message['result_code'],
                        'return_code' => $message['return_code'],
                    ]);

                    // 创建订单记录
                    if ($payLog->type == 1) {
                        TableModels\PackageOrder::insert([
                            'order_num' => $message['out_trade_no'],
                            'customer_id' => $payLog->info['customer_id'],
                            'package_id' => $payLog->info['package_id'],
                            'payment_count' => $message['total_fee'],
                            'pay_log_id' => $payLog->id,
                            'payment_status' => 1,
                        ]);

                        $customer_id = $payLog->info['customer_id'];
                        $package_id = $payLog->info['package_id'];
                        $customer = TableModels\Customer::find($customer_id);
                        // 添加套餐
                        $customer->packages()->attach($package_id, [
                            'left_count' => $payLog->info['maintenance_count'],
                            'qr_code' => "customer_id=$customer_id&package_id=$package_id",
                        ]);

                        if (!is_null($customer->recommender)) {

                            $broker = TableModels\Customer::find($customer->recommender);
                            \Log::info("broker: " . $broker->id . " 消费" . $message['total_fee']);

                            if ((!is_null($broker)) && ($broker->type == 2) && ($broker->type_auth == 1)) {
                                TableModels\CustomerRecharge::create([
                                    'customer_id' => $broker->id,
                                    'score' => floor($message['total_fee'] * 5/10000),
                                    'content' => '推荐人消费积分奖励',
                                ]);
                                $broker->score += floor($message['total_fee'] * 5/10000);
                                $broker->save();
                            }
                        }
                    }

                    //现金充值
                    if ($payLog->type == 2) {
                        TableModels\MallRecharge::insert([
                            'customer_id' => $payLog->info['customer_id'],
                            'count' => $message['total_fee'],
                            'type' => 1,
                        ]);

                        // 推荐人奖励
                        $customer = TableModels\Customer::find($customer_id);

                        if (!is_null($customer->recommender)) {
                            $broker = TableModels\Customer::find($customer->recommender);
                            if (!is_null($broker)) {
                                TableModels\CustomerRecharge::create([
                                    'customer_id' => $broker->id,
                                    'score' => floor($message['total_fee'] * (getMoneyThreshold()['relation_return_money']) / 10000),
                                    'content' => "推荐人:" . $customer->phone . "积分充值奖励",
                                ]);
                            }
                            $broker->score += floor($message['total_fee'] * (getMoneyThreshold()['relation_return_money']) / 10000);
                            $broker->save();
                        }
                        
                        // 代理商奖励
                    }

                    //商城订单
                    if ($payLog->type == 3) {
                        // 更新状态为待发货
                        TableModels\MallAccessoryOrder::where('uuid', $message['out_trade_no'])->update([
                            'status' => 2
                        ]);

                        //商城商品销量增加
                        TableModels\MallAccessory::where('id', $payLog->info['mall_accessory_id'])
                            ->increment('count', $payLog->info['mall_accessory_count']);

                        // 推荐人奖励
                        
                        // 代理商奖励
                    }

                    // 创建订单支付成功通知信息
                    TableModels\OrderMessage::insert([
                        'customer_id' => $payLog->info['customer_id'],
                        'content' => '您的订单支付成功',
                        'order_num' => $message['out_trade_no'],
                    ]);

                } else {

                    // 如果支付失败, 也更新 PayLog, 跟上面一样, 就是多了 error 信息
                    TableModels\PayLog::where('out_trade_no', $message['out_trade_no'])->update([
                        'appid' => $message['appid'],
                        'bank_type' => $message['bank_type'],
                        'total_fee' => $message['total_fee'],
                        'trade_type' => $message['trade_type'],
                        'is_subscribe' => $message['is_subscribe'],
                        'mch_id' => $message['mch_id'],
                        'nonce_str' => $message['nonce_str'],
                        'openid' => $message['openid'],
                        'sign' => $message['sign'],
                        'cash_fee' => $message['cash_fee'],
                        'fee_type' => $message['fee_type'],
                        'transaction_id' => $message['transaction_id'],
                        'time_end' => date("Y-m-d H:i:s"),
                        'result_code' => $message['result_code'],
                        'return_code' => $message['return_code'],
                        'err_code' => $message['err_code'],
                        'err_code_des' => $message['err_code_des'],
                    ]);

                    // 创建订单支付失败通知信息
                    TableModels\OrderMessage::insert([
                        'customer_id' => $payLog->info['customer_id'],
                        'content' => $message['err_code_des'],
                        'order_num' => $message['out_trade_no'],
                    ]);

                    return $fail('通信失败，请稍后再通知我');
                }

                return true;
            }
        });

        return $response;
    }
}
