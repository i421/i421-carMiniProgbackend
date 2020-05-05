<?php

namespace App\Jobs\Backend\Setting;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class GetMoneyJob
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
            'data' => getMoneyThreshold(),
        ];

        return response()->json($response);
    }
}
