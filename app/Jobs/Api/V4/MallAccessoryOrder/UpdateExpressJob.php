<?php

namespace App\Jobs\Api\V4\MallAccessoryOrder;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateExpressJob
{
    private $id;
    private $express_number;

    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->id = isset($params['id']) ? $params['id'] : null;
        $this->express_number = isset($params['express_number']) ? $params['express_number'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (is_null($this->express_number) || is_null($this->id)) {

            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);
        }

        $mallAccessoryOrder = TableModels\MallAccessoryOrder::where('id', $this->id)->update(['express_number' => $this->express_number]);

        if (!$mallAccessoryOrder) {
            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
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
