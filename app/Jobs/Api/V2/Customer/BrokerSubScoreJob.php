<?php

namespace App\Jobs\Api\V2\Customer;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class BrokerSubScoreJob
{
    use Dispatchable, Queueable;

    private $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = TableModels\Customer::where('openid', $this->params['openid'])->first();

        if (is_null($customer)) {
            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);
        }

        $temp = $customer->broker_info;

        if (!isset($temp['wechat_payment_code'])) {
            $response = [
                'code' => trans('pheicloud.response.missWechatPaymentCode.code'),
                'msg' => trans('pheicloud.response.missWechatPaymentCode.msg'),
            ];

            return response()->json($response);
        }

        $customer_id = $customer->id;

        if ($customer->score < $this->params['score']) {

            $response = [
                'code' => trans('pheicloud.response.outOfRange.code'),
                'msg' => trans('pheicloud.response.outOfRange.msg'),
            ];

            return response()->json($response);
        }

        $total_score = TableModels\CustomerRecharge::where('customer_id', $customer_id)->sum('score');
        $already_score = TableModels\CustomerRecycling::where('customer_id', $customer_id)->sum('score');

        $can_sub = floor($total_score * 0.4) - $already_score;

        if ($can_sub < (int)$this->params['score']) {

            $response = [
                'code' => trans('pheicloud.response.outOfRange.code'),
                'msg' => trans('pheicloud.response.outOfRange.msg'),
            ];

            return response()->json($response);
        }

        $customer->score -= $this->params['score'];
        $customer->save();

        $ratio = (getMoneyThreshold()['recycleRatio']) /100;

        \Log::info("score: " . $this->params['score'] . "---- ratio: " . $ratio);

        $money = round($this->params['score'] * (1 - $ratio), 2);

        $res = TableModels\CustomerRecycling::insert([
            'customer_id' => $customer_id,
            'score' => $this->params['score'],
            'money' => $money,
        ]);

        if (!$res) {

            $response = [
                'code' => trans('pheicloud.response.error.code'),
                'msg' => trans('pheicloud.response.error.msg'),
            ];

            return response()->json($response);
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
        ];

        return response()->json($response);
    }
}
