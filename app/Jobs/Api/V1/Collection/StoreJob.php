<?php

namespace App\Jobs\Api\V1\Collection;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class StoreJob
{
    use Dispatchable, Queueable;

    private $car_id;
    private $customer_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->car_id = $params['car_id'];
        $this->customer_id = $params['customer_id'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $flag = TableModels\Collection::where([
            ['car_id', '=', $this->car_id],
            ['customer_id', '=', $this->customer_id],
        ])->first();

        if (empty($flag)) {

            $collection = TableModels\Collection::create([
                'car_id' => $this->car_id,
                'customer_id' => $this->customer_id,
            ]);

            if ($collection) {
                $code = trans('pheicloud.response.success.code');
                $msg = trans('pheicloud.response.success.msg');
            } else {
                $code = trans('pheicloud.response.error.code');
                $msg = trans('pheicloud.response.error.msg');
            }

        } else {
            $code = trans('pheicloud.response.exist.code');
            $msg = trans('pheicloud.response.exist.msg');
        }

        $response = [
            'code' => $code,
            'msg' => $msg,
        ];

        return response()->json($response);
    }
}
