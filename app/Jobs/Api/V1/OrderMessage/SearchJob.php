<?php

namespace App\Jobs\Api\V1\OrderMessage;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TablesModels;

class SearchJob
{
    use Dispatchable, Queueable;

    private $customer_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->customer_id = $params['customer_id'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = TablesModels\OrderMessage::where('customer_id', '=', $this->customer_id)->get()->toArray();

        if (count($data) < 1) {
            $code = trans('pheicloud.response.empty.code');
            $msg = trans('pheicloud.response.empty.msg');
        } else {
            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');
        }

        $response = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];

        return response()->json($response);
    }
}
