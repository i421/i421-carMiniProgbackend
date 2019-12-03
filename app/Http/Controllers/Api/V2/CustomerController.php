<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V2\Customer as CustomerJobs;

class CustomerController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * 更新用户信息: 姓名手机号、身份证、银行卡
     */
    public function improveBrokerInfo(CustomerRequests\ImproveBrokerInfoRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\ImproveBrokerInfoJob($params));
        return $response;
    }
}
