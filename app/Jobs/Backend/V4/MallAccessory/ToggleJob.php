<?php

namespace App\Jobs\Backend\V4\MallAccessory;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class ToggleJob
{
    use Dispatchable, Queueable;

    private $id;
    private $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id, int $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mallAccessory = TableModels\MallAccessory::find($this->id);

        if (is_null($mallAccessory)) {
            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);
        }

        if ($this->status == 0) {
            $mallAccessory->status = 1;
        } else {
            $mallAccessory->status = 0;
        }
        $mallAccessory->save();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
        ];

        return response()->json($response);
    }
}
