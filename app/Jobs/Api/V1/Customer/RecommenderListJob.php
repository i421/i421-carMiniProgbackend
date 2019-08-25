<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class RecommenderListJob
{
    use Dispatchable, Queueable;

    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $openid)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orders = TableModels\Customer::leftJoin('orders', 'orders.customer_id', '=', 'customers.id')
            ->where('customers.recommender', '=', $this->id)
            ->select(
                'customers.*', DB::raw('count(*) as order_count')
            )->orderBy("created_at", 'desc')
            ->groupBy('customers.openid')
            ->get()
            ->toArray();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $orders,
        ];

        return response()->json($response);
    }
}
