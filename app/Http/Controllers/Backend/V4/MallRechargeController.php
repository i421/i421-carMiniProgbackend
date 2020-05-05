<?php

namespace App\Http\Controllers\Backend\V4;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Backend\V4\MallRecharge as MallRechargeJobs;

class MallRechargeController extends Controller
{
    /**
     * 查询充值列表
     */
    public function search()
    {
        $params = request()->all();
        $response = $this->dispatch(new MallRechargeJobs\SearchJob($params));
        return $response;
    }
}
