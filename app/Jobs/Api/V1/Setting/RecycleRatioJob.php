<?php

namespace App\Jobs\Api\V1\Setting;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class RecycleRatioJob
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
        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => (int)getMoneyThreshold()['recycleRatio'],
        ];

        return response()->json($response);        
    }
}
