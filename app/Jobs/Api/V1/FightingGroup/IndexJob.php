<?php

namespace App\Jobs\Api\V1\FightingGroup;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

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
        $timeGroup = TableModels\Car::where([
            ['type', '=', '2'],
            ['group_type', '=', '1'],
            ['end_time', '>=', date("Y-m-d H:i:s")]
        ])->orderBy('id', 'desc')->get();

        $countGroup = TableModels\Car::where([
            ['type', '=', '2'],
            ['group_type', '=', '2'],
            ['end_time', '>=', date("Y-m-d H:i:s")]
        ])->orderBy('id', 'desc')->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => [
                'timegroup' => $timeGroup,
                'countGroup' => $countGroup,
            ],
        ];

        return response()->json($response);
    }
}
