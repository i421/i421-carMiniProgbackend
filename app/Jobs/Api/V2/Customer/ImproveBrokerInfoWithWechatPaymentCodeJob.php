<?php

namespace App\Jobs\Api\V2\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class ImproveBrokerInfoWithWechatPaymentCodeJob
{
    use Dispatchable, Queueable;

    private $openid;
    private $name;
    private $id_card;
    private $wechat_payment_code;
    private $bank_card;
    private $id_card_front_path;
    private $id_card_back_path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->openid = $params['openid'];
        $this->name = $params['name'];
        $this->id_card = $params['id_card'];
        $this->wechat_payment_code = $params['wechat_payment_code'];
        $this->bank_card = isset($params['bank_card']) ? $params['bank_card'] : '';
        $this->id_card_front_path = isset($params['id_card_front_path']) ? $params['id_card_front_path'] : '';
        $this->id_card_back_path = isset($params['id_card_back_path']) ? $params['id_card_back_path'] : '';
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
            $brokerInfoArr['name'] = $this->name;
            $brokerInfoArr['id_card'] = $this->id_card;
            $brokerInfoArr['wechat_payment_code'] = $this->wechat_payment_code;
            $brokerInfoArr['id_card_front_path'] = $this->id_card_front_path;
            $brokerInfoArr['id_card_back_path'] = $this->id_card_back_path;
            $brokerInfoArr['bank_card'] = $this->bank_card;
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
