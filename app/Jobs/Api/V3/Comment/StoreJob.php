<?php

namespace App\Jobs\Api\V3\Comment;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Comment;
use App\Tables\Customer;

class StoreJob
{
    use Dispatchable, Queueable;

    private $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $miniProgram = \EasyWeChat::miniProgram();
        $result = $miniProgram->content_security->checkText($this->params['content']);

        if ($result['errcode'] !== 0) {
                $response = [
                    'code' => '71010',
                    'msg' => '内容含敏感信息',
                ];
                return response()->json($response);
        }

        $customer = Customer::where('id', $this->params['customer_id'])->first();
        if (is_null($customer) || is_null($customer->phone) && empty($customer->phone)) {
            $response = [
                'code' => trans('pheicloud.response.error.code'),
                'msg' => trans('pheicloud.response.error.msg'),
            ];

            return response()->json($response);
        }

        $res = Comment::create($this->params);

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $res,
        ];

        return response()->json($response);
    }
}
