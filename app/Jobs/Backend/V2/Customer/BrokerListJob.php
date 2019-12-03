<?php

namespace App\Jobs\Backend\V2\Customer;

use App\Tables as TableModels;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class BrokerListJob
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
        $customers = TableModels\Customer::isBroker()->get();
        $scores = TableModels\CustomerRecharge::select('customer_id', DB::raw("sum(score) as scores"))
            ->groupBy('customer_id')
            ->get();

        $recyclingScores = TableModels\CustomerRecycling::select('customer_id', DB::raw("sum(score) as scores"))
            ->where('status', '1')
            ->groupBy('customer_id')
            ->get();

        foreach ($customers as & $customer) {

            //初始化
            $customer->score_count = 0;
            $customer->recycling_score_count = 0;

            foreach ($scores as $score) {
                if ($customer->id == $score->customer_id) {
                    $customer->score_count = $score->scores;
                }
            }

            foreach ($recyclingScores as $atom) {
                if ($customer->id == $atom->customer_id) {
                    $customer->recycling_score_count = $atom->scores;
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
