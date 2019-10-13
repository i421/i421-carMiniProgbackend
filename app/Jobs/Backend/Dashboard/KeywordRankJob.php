<?php

namespace App\Jobs\Backend\Dashboard;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class KeywordRankJob
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
        $data = TableModels\KeywordSearch::select('word as name', 'count as value')
            ->orderBy('value', 'desc')
            ->limit(15)
            ->get()->toArray();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $data,
        ];

        return response()->json($response);
    }
}
