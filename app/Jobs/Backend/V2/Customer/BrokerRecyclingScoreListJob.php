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
            ->select("customer_recyclings.*", 'customers.nickname as nickname', 'customers.phone as phone', 'customers.openid as openid');

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

        $res = $tempRes->orderBy("customer_recyclings.created_at", 'desc')
            ->get();

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
