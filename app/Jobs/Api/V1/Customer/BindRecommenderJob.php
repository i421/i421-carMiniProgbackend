<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class BindRecommenderJob
{
    use Dispatchable, Queueable;

    private $id;
    private $openid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->id = $params['id'];
        $this->openid = $params['openid'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        TableModels\Customer::where('id', '=', $this->id)->increment('recommend_count');
        TableModels\Customer::where('openid', '=', $this->openid)->update(['recommender' => $this->id]);

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
        ];

        return response()->json($response);
    }
}
