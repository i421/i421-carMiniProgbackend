<?php

namespace App\Jobs\Backend\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class CheckListJob
{
    use Dispatchable, Queueable;

    private $opend_id;
    private $phone;
    private $start_time;
    private $end_time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->open_id = isset($params['open_id']) ? $params['open_id'] : null;
        $this->phone = isset($params['phone']) ? $params['phone'] : null;
        $this->start_time = isset($params['start_time']) ? $params['start_time'] : null;
        $this->end_time = isset($params['end_time']) ? $params['end_time'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = TableModels\Customer::select('id', 'openid', 'phone', 'nickname', 'status');

        if (! is_null($this->open_id)) {
            $tempRes = $tempRes->where('open_id', 'like', "%$this->open_id%");
        }

        if (! is_null($this->phone)) {
            $tempRes = $tempRes->where('phone', 'like', "%$this->phone%");
        }

        if (! is_null($this->start_time)) {
            $tempRes = $tempRes->where('created_at', '>=', $this->start_time);
        }

        if (! is_null($this->end_time)) {
            $tempRes = $tempRes->where('created_at', '<=', $this->end_time);
        }

        $res = $tempRes->get()->toArrary();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $res,
        ];

        return response()->json($response);
    }
}
