<?php

namespace App\Jobs\Api\V3\Customer;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use EasyWeChat\Factory;
use function EasyWeChat\Kernel\Support\generate_sign;

class BuyPackageJob
{
    use Dispatchable, Queueable;

    private $app;
    private $customer_id;
    private $package_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->app = Factory::payment(config('wechat.payment.default'));
        $this->customer_id = $params['customer_id'];
        $this->package_id = $params['package_id'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = TableModels\Customer::find($this->customer_id);
        $package = TableModels\Package::find($this->package_id);

        // 订单号
        $order_num = date("ymd") . substr(time(), -5) . substr(microtime(), 2, 5);
        // 套餐价格 元换成分
        $payment_count = bcmul($package->price, 100);

        $info = [
            'customer_id' => $this->customer_id,
            'package_id' => $this->package_id,
            'maintenance_count' => $package->maintenance_count,
            // 购买套餐 用于回调区分
            'type' => '1',
        ];

        TableModels\PayLog::insert([
            'appid' => config('wechat.payment.default.app_id'),
            'mch_id' => config('wechat.payment.default.mch_id'),
            'out_trade_no' => $order_num,
            'info' => json_encode($info);
        ]);

        $result = $this->app->order->unify([
            'trade_type' => 'JSAPI',
            'body' => $package->name ?? "套餐价格",
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
}
