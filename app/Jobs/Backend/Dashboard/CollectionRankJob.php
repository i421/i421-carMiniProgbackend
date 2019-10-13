<?php

namespace App\Jobs\Backend\Dashboard;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class CollectionRankJob
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
        $data = TableModels\Collection::leftJoin('cars', 'collections.car_id', '=', 'cars.id')
            ->select(DB::raw('count(*) as value'), 'cars.name as name')->groupBy('car_id')
            ->orderBy('value', 'desc')
            ->limit(15)
            ->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $data,
        ];

        return response()->json($response);
    }
}
