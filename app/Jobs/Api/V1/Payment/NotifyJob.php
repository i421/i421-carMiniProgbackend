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

            \Log::info(json_encode($message));

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
                    //更新支付时间为当前时间
                    $payLog->time_end = time();

                    // 创建订单记录
                    Order::create([
                        'order_num' => $message['out_trade_no'],
                        'customer_id' => $payLog->info['customer_id'],
                        'car_id' => $payLog->info['car_id'],
                        'shop_id' => $payLog->info['shop_id'],
                        'type' => $payLog->info['type'],
                        'fighting_group_id' => $payLog->info['fighting_group_id'],
                        'payment_count' => $message['total_fee'],
                        'pay_log_id' => $payLog->id,
                        'payment_status' => 1,
                    ]);

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
                        'time_end' => $payLog->paid_at,
                        'result_code' => $message['result_code'],
                        'return_code' => $message['return_code'],
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
                        'time_end' => $payLog->paid_at,
                        'result_code' => $message['result_code'],
                        'return_code' => $message['return_code'],
                        'err_code' => $message['err_code'],
                        'err_code_des' => $message['err_code_des'],
                    ]);

                    return $fail('通信失败，请稍后再通知我');
                }

                return true;
            }
        });

        return $response;
    }
}