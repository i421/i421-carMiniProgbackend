<?php

namespace App\Http\Controllers\Backend\V3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Backend\V3\Customer as CustomerJobs;

class CustomerController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * 已购买套餐
     */
    public function packages()
    {
        $params = request()->all();
        $response = $this->dispatch(new CustomerJobs\PackageListJob($params));
        return $response;
    }

    /**
     * 某一用户套餐列表
     */
    public function package($id)
    {
        $response = $this->dispatch(new CustomerJobs\PackageJob($id));
        return $response;
    }
}
