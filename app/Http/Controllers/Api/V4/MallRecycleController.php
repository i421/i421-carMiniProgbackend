<?php

namespace App\Http\Controllers\Api\V4;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V4\MallRecycle as MallRecycleJobs;

class MallRecycleController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * 消费列表
     */
    public function search()
    {
        $params = request()->all();
        $response = $this->dispatch(new MallRecycleJobs\SearchJob($params));
        return $response;
    }
}
