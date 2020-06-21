<?php

namespace App\Jobs\Backend\V4\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class IsAgentJob
{
    use Dispatchable, Queueable;

    private $id;
    private $is_agent;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->id = $params['id'];
        $this->is_agent = $params['is_agent'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = TableModels\Customer::find($this->id);

        if (is_null($customer)) {

            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);

        }

        // 如果设置为代理人， 则遍历父级判定父级中是否存在 代理人 如果存在 则设置为代理人， 并取消之前的绑定
        if ($this->is_agent == 1) {
            $customer->is_agent = $this->is_agent;
            $customer->recommender = null;
            $customer->save();
        } else {
            $customer->is_agent = $this->is_agent;
            $customer->save();
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
        ];

        return response()->json($response);
    }
}
