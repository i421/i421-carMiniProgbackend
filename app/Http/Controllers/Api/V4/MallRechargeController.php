<?php

namespace App\Http\Controllers\Api\V4;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V4\MallRecharge as MallRechargeJobs;

class MallRechargeController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * 充值列表
     */
    public function search()
    {
        $params = request()->all();
        $response = $this->dispatch(new MallRechargeJobs\SearchJob($params));
        return $response;
    }
}
