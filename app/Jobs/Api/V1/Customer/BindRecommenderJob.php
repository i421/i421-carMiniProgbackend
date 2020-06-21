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
	\Log::info("[bind] id:" . $this->id . "---- openid:" . $this->openid);

        $res = TableModels\Customer::where('id', '=', $this->id)->first();

        if (!$res) {

            $response = [
                'code' => trans('pheicloud.response.normalException.code'),
                'msg' => trans('pheicloud.response.normalException.msg'),
            ];

            return response()->json($response);
        }

        $customer = TableModels\Customer::where('openid', '=', $this->openid)->first();

        if ($customer->recommender == null) {

            TableModels\Customer::where('id', '=', $this->id)->increment('recommend_count');
            TableModels\Customer::where('id', '=', $this->id)->increment('score', getScoreThreshold()['recommend']);
            TableModels\Customer::where('openid', '=', $this->openid)->update(['recommender' => $this->id]);

            TableModels\Customer::where('openid', '=', $this->openid)->increment('score', getScoreThreshold()['store']);

            //自己积分计算
            TableModels\CustomerRecharge::create([
                'customer_id' => $customer->id,
                'score' => getScoreThreshold()['store'],
                'content' => '注册积分奖励',
            ]);

            //推荐人积分计算
            TableModels\CustomerRecharge::create([
                'customer_id' => $this->id,
                'score' => getScoreThreshold()['recommend'],
                'content' => '推荐积分奖励',
            ]);
        } else {
		$response = [
		    'code' => '71000',
		    'msg' => '已经绑定',
		];

		return response()->json($response);
	}

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
        ];

        return response()->json($response);
    }
}
