<?php

namespace App\Jobs\Api\V3\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Forum;
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
                    'code' => $result['errcode'],
                    'msg' => $result['errmsg'],
                ];
                return response()->json($response);
        }

        $customer = Customer::where('id', $this->params['customer_id'])->first();
        if (is_null($customer) || is_null($customer->phone) || empty($customer->phone)) {
            $response = [
                'code' => trans('pheicloud.response.error.code'),
                'msg' => trans('pheicloud.response.error.msg'),
            ];
            return response()->json($response);
        }

        $res = Forum::create($this->params);

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $res,
        ];

        return response()->json($response);
    }
}
