<?php

namespace App\Jobs\Backend\V2\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class ShowJob
{
    use Dispatchable, Queueable;

    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id)
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
        $customer = TableModels\Customer::find($this->id);

        $scoreCount = TableModels\CustomerRecharge::where('customer_id', $this->id)->sum('score');
        $recyclingScoreCount = TableModels\CustomerRecycling::where('customer_id', $this->id)->sum('score');
	
        if (is_null($customer)) {

            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);

        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $customer,
            'append' => [
                'scoreCount' => $scoreCount,
                'recyclingScoreCount' => $recyclingScoreCount,
            ],
        ];

        return response()->json($response);
    }
}
