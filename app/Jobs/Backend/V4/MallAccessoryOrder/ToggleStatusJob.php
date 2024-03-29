<?php

namespace App\Jobs\Backend\V4\MallAccessoryOrder;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class ToggleStatusJob
{
    private $id;
    private $status;
    private $express_num;

    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->id = isset($params['id']) ? $params['id'] : null;
        $this->status = isset($params['status']) ? $params['status'] : null;
        $this->express_num = isset($params['express_num']) ? $params['express_num'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (is_null($this->status) || is_null($this->id)) {

            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);
        }

        $mallAccessoryOrder = TableModels\MallAccessoryOrder::where([
            ['id', '=', $this->id],
            ['status', '=', 2],
        ])->first();

        if (is_null($mallAccessoryOrder)) {
            $response = [
                'code' => trans('pheicloud.response.error.code'),
                'msg' => trans('pheicloud.response.error.msg'),
            ];

            return response()->json($response);
        }

        TableModels\MallAccessoryOrder::where('id', '=', $this->id)->update([
            'express_number' => $this->express_num,
            'status' => $this->status,
        ]);

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
        ];

        return response()->json($response);
    }
}
