<?php

namespace App\Jobs\Api\V2\FightingGroup;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class OffJob
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
        $data = TableModels\Car::where([
            ['type', '=', 2],
            ['group_recommend', '=', 1],
            ['end_time', '>=', date("Y-m-d H:i:s")],
        ])->orderBy('created_at', 'desc')
        ->take(6)
        ->get()
        ->toArray();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $data,
        ];

        return response()->json($response);
    }
}
