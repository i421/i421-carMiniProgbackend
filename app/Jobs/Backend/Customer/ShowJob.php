<?php

namespace App\Jobs\Backend\Customer;

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

        $collectionCount = TableModels\Collection::where('customer_id', $this->id)->count();
        $orderCount = TableModels\Order::where('customer_id', $this->id)->count();
        $scoreCount = TableModels\Score::where('customer_id', $this->id)->sum('count');
	
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
                'collection' => $collectionCount,
                'orderCount' => $orderCount,
                'scoreCount' => $scoreCount,
            ],
        ];

        return response()->json($response);
    }
}
