<?php

namespace App\Jobs\Api\V2\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class UpdateWechatPaymentCodeJob
{
    use Dispatchable, Queueable;

    private $openid;
    private $wechat_payment_code;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->openid = $params['openid'];
        $this->wechat_payment_code = $params['wechat_payment_code'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = TableModels\Customer::where("openid", $this->openid)->first();

        if (!empty($customer)) {

            $brokerInfoArr = json_decode($customer->getOriginal('broker_info'), true);
            $brokerInfoArr['wechat_payment_code'] = $this->wechat_payment_code;
            $customer->broker_info = $brokerInfoArr;
            $customer->save();

        } else {

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
