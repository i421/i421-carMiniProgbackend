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

    /**
     * 提积分
     *
     * @return void
     */
    public function brokerSubScore(CustomerRequests\BrokerSubScoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\BrokerSubScoreJob($params));
        return $response;
    }

    /**
     * 提积分列表
     *
     * @return void
     */
    public function brokerRecyclingScoreList(string $openid)
    {
        $response = $this->dispatch(new CustomerJobs\BrokerRecyclingScoreListJob($openid));
        return $response;
    }

    /**
     * 增加积分列表
     *
     * @return void
     */
    public function brokerRechargeScoreList(string $openid)
    {
        $response = $this->dispatch(new CustomerJobs\BrokerRechargeScoreListJob($openid));
        return $response;
    }
}
