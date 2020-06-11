<?php

namespace App\Jobs\Api\V2\Customer;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class BrokerRechargeScoreListJob
{
    use Dispatchable, Queueable;

    private $openid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $openid)
    {
        $this->openid = $openid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $recharges = TableModels\CustomerRecharge::join('customers', 'customer_recharges.customer_id', '=', 'customers.id')
            ->where('customers.openid', $this->openid)
            ->select('customers.phone as phone', 'customers.nickname as nickname', 'customers.phone as phone', 'customer_recharges.*')
            ->orderBy("customer_recharges.created_at", 'desc')
            ->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $recharges,
        ];

        return response()->json($response);
    }
}
