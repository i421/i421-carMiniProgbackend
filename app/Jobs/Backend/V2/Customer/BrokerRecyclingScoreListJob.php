<?php

namespace App\Jobs\Backend\V2\Customer;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class BrokerRecyclingScoreListJob
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
        $tempRes = TableModels\CustomerRecycling::leftJoin('customers', 'customer_recyclings.customer_id', 'customers.id')
            ->select("customer_recyclings.*", 'customers.nickname as nickname', 'customers.phone as phone', 'customers.openid as openid', 'broker_info');

        if (isset($this->params['phone']) && !empty($this->params['phone'])) {
            $tempRes->where('customers.phone', 'like', '%' . $this->params['phone'] . '%');
        }

        if (isset($this->params['nickname']) && !empty($this->params['nickname'])) {
            $tempRes->where('customers.nickname', 'like', '%' . $this->params['nickname'] . '%');
        }

        if (isset($this->params['time']) && count($this->params['time']) >= 1) {
            $tempRes->where([
                ['customer_recyclings.created_at', '>=', $this->params['time'][0] . ' 00:00:00'],
                ['customer_recyclings.created_at', '<=', $this->params['time'][1] . ' 23:59:59']
            ]);
        }

        if (isset($this->params['status']) && count($this->params['status']) >= 1) {
            $tempRes->whereIn('customer_recyclings.tatus', $this->params['status']);
        }

        $res = $tempRes->orderBy("customer_recyclings.created_at", 'desc')
            ->get();

        foreach ($res as &$atom) {
                $temp = json_decode($atom->broker_info,true);
                if (isset($temp['wechat_payment_code'])) {
                    $temp['wechat_payment_code'] = '/storage/'. $temp['wechat_payment_code'];
                    $temp['full_wechat_payment_code'] = url('/') . $temp['wechat_payment_code'];
                } else {
                    $temp['full_wechat_payment_code'] = '';
                    $temp['wechat_payment_code'] = '';
                }

                $atom->broker_info = $temp;
        }


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
            'data' => $res,
        ];

        return response()->json($response);
    }
}
