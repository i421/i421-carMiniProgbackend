<?php

namespace App\Jobs\Backend\V2\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class CheckBrokerListJob
{
    use Dispatchable, Queueable;

    private $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
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
        $tempRes = TableModels\Customer::select('id', 'openid', 'phone', 'nickname', 'type_auth as auth');

        if (!is_null($this->params['nickname']) && !empty($this->params['nickname'])) {
            $tempRes->where('nickname', $this->params['nickname']);
        }

        if (!is_null($this->params['phone']) && !empty($this->params['phone'])) {
            $tempRes->where('phone', $this->params['phone']);
        }

        if (!is_null($this->params['time']) && count($this->params['time']) >= 1) {
            $tempRes->where([
                ['created_at', '>=', $this->params['time'][0] . ' 00:00:00'],
                ['created_at', '<=', $this->params['time'][1] . ' 23:59:59']
            ]);
        }

        $res = $tempRes->isBroker()->get()->toArray();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $res,
        ];

        return response()->json($response);
    }
}
