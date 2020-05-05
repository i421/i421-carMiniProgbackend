<?php

namespace App\Jobs\Api\V1\Payment;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class ScoreJob
{
    use Dispatchable, Queueable;

    //支付金额元
    private $payment_count;
    // 用户ID
    private $customer_id;
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
        $this->payment_count = $params['payment_count'];
        $this->customer_id = $params['customer_id'];
        $this->mall_accessory_id = isset($params['mall_accessory_id']) ? $params['mall_accessory_id'] : null;
        $this->mall_accessory_count = isset($params['mall_accessory_count']) ? $params['mall_accessory_count'] : 1;
        $this->mall_address_id = isset($params['mall_address_id']) ? $params['mall_address_id'] : null;
        $this->mall_accessory_detail = isset($params['mall_accessory_detail']) ? json_encode($params['mall_accessory_detail']) : '';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
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
        $payment_count = $this->payment_count;

        if ($customer->score < $payment_count) {
            $response = [
                'code' => '80001',
                'msg' => '积分不足',
            ];
            return response()->json($response);
        }

        $info = [
            'type' => 4,
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
            'type' => 4,
        ]);

        // 创建订单
        TableModels\MallAccessoryOrder::insert([
            'customer_id' => $this->customer_id,
            'mall_accessory_id' => $this->mall_accessory_id,
            'mall_address_id' => $this->mall_address_id,
            'status' => 2,
            //积分支付
            'pay_type' => 2,
            'pay_price' => $this->payment_count,
            'uuid' => $order_num,
        ]);

        //商城商品销量增加
        TableModels\MallAccessory::where('id', $this->mall_accessory_id)->increment('count', $this->mall_accessory_count);

        $customer->score -= $this->payment_count;
        $customer->save();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => []
        ];
        return response()->json($response);
    }
}
