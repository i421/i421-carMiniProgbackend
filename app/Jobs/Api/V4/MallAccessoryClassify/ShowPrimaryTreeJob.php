<?php

namespace App\Jobs\Api\V4\MallAccessoryClassify;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class ShowPrimaryTreeJob
{
    use Dispatchable, Queueable;

    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mallAccessoryClassifies = TableModels\MallAccessoryClassify::select("id", 'name', 'type', 'p_id as pid', 'p_name as p_name', 'height as order', 'img')
            ->where("p_id", '=', $this->id)
            ->orderBy('height', 'desc')
            ->get()
            ->toArray();

        if (count($mallAccessoryClassifies) < 1) {
            $response = [
                'code' => trans('pheicloud.response.empty.code'),
                'msg' => trans('pheicloud.response.empty.msg'),
            ];

            return response()->json($response);
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallAccessoryClassifies,
        ];

        return response()->json($response);
    }
}
