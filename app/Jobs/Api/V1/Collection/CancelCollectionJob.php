<?php

namespace App\Jobs\Api\V1\Collection;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Collection;
use stdClass;

class CancelCollectionJob
{
    use Dispatchable, Queueable;

    /**
     * @var integer $id
     */
    private $customer_id;
    private $car_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params)
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
        $collection = Collection::where([
            ['car_id', '=', $this->car_id],
            ['customer_id', '=', $this->customer_id]
        ])->delete();

        if ($collection) {

            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');

        } else {

            $code = trans('pheicloud.response.error.code');
            $msg = trans('pheicloud.response.error.msg');

        }

        $response = [
            'code' => $code,
            'msg' => $msg,
            'data' => new stdClass(),
        ];

        return response()->json($response);
    }
}
