<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\Payment as PaymentRequests;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V1\Payment as PaymentJobs;

class PaymentController extends Controller
{
    /*
     * 向微信请求统一下单接口, 创建预支付订单
     *
     * @param integer $payment_count
     * @param array $info[customer_id, car_id, shop_id]
     */
    public function pre_order(PaymentRequests\PreOrderRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new PaymentJobs\PreOrderJob($params));
        return $response;
    }

    // 接收微信支付状态的通知
    public function notify()
    {
        $response = $this->dispatch(new PaymentJobs\NotifyJob());
        return $response;
    }

    // 请求微信接口查看支付状态
	public function paid(PaymentRequests\PaidRequest $request)
    {
        $out_trade_no = $request->input('out_trade_no');
        $response = $this->dispatch(new PaymentJobs\PaidJob($out_trade_no));
        return $response;
    }

    /*
     * 商城积分消费
     *
     * @param integer $payment_count
     * @param array $info[customer_id, car_id, shop_id]
     */
    public function score(PaymentRequests\ScoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new PaymentJobs\ScoreJob($params));
        return $response;
    }
}
