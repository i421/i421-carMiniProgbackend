<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class SearchRecommenderJob 
{
    use Dispatchable, Queueable;

    private $id;
    private $openid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
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
        $res = TableModels\Customer::where('id', '=', $this->id)->first();

        if (is_null($res)) {

            $response = [
                'code' => trans('pheicloud.response.success.code'),
                'msg' => trans('pheicloud.response.success.msg'),
                'data' => null,
            ];

            return response()->json($response);
        
        }

        $customer_id = $res->recommender;

        $data = TableModels\Customer::select('id', 'nickname', 'phone', 'avatar')->find($customer_id);

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $data,
        ];

        return response()->json($response);
    }
}
