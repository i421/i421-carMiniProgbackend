<?php

namespace App\Jobs\Api\V4\MallAccessoryClassify;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class IndexJob
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mallAccessoryClassifies = TableModels\MallAccessoryClassify::select('id', 'name', 'type', 'p_name', 'p_id as pid', 'height',  'height as order', 'img')
            ->orderBy('type', 'asc')
            ->orderBy('height', 'desc')
            ->get()
            ->toArray();

        $mallAccessoryClassifies = classifyTree($mallAccessoryClassifies);

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallAccessoryClassifies,
        ];

        return response()->json($response);
    }
}
