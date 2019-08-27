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
    public function __construct(string $id)
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
        $customers = TableModels\Customer::select(
	   	'info->name as name', 'id', 'openid', 'nickname', 'avatar', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date')
	    )->where('recommender', '=', $this->id)->groupBy('openid', 'info', 'created_at', 'id', 'nickname', 'avatar')->get();

        $orders = TableModels\Order::select('customer_id', DB::raw("count(*) as orders"))->where('payment_status', 1)->groupBy('customer_id')->get();

        foreach ($customers as & $customer) {

            $customer->order_count = 0;

            foreach ($orders as $order) {
                if ($customer->id == $order->customer_id) {
                    $customer->order_count = $order->orders;
                }
            }
	}

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $customers,
        ];

        return response()->json($response);
    }
}
