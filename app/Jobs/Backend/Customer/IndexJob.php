<?php

namespace App\Jobs\Backend\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class IndexJob
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$customers = TableModels\Customer::isNormal()->get();
        $customers = TableModels\Customer::all();
        $scores = TableModels\Score::select('customer_id', DB::raw("sum(count) as scores"))->groupBy('customer_id')->get();
        $orders = TableModels\Order::select('customer_id', DB::raw("count(*) as orders"))->where('payment_status', 1)->groupBy('customer_id')->get();
        $collections = TableModels\Collection::select('customer_id', DB::raw("count(*) as collections"))->groupBy('customer_id')->get();

        foreach ($customers as & $customer) {

            //初始化
            $customer->score_count = 0;
            $customer->order_count = 0;
            $customer->collection_count = 0;

            foreach ($scores as $score) {
                if ($customer->id == $score->customer_id) {
                    $customer->score_count = $score->scores;
                }
            }
            foreach ($orders as $order) {
                if ($customer->id == $order->customer_id) {
                    $customer->order_count = $order->orders;
                }
            }
            foreach ($collections as $collection) {
                if ($customer->id == $collection->customer_id) {
                    $customer->collection_count = $collection->collections;
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
