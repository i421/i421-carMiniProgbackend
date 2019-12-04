<?php

namespace App\Jobs\Api\V2\Customer;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class BrokerRecyclingScoreListJob
{
    use Dispatchable, Queueable;

    private $openid

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
        $recyclings = TableModels\CustomerRecycling::join('customers', 'customer_recyclings.customer_id', '=', 'customers.id')
            ->where('customers.openid', $this->openid)
            ->select('customers.phone as phone', 'customers.nickname as nickname', 'customers.phone as phone', 'customer_recyclings.*')
            ->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $recharges,
        ];

        return response()->json($response);
    }
}
