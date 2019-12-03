<?php

namespace App\Http\Controllers\Backend\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\V2\Customer as CustomerRequests;
use App\Jobs\Backend\V2\Customer as CustomerJobs;

class CustomerController extends Controller
{
    /**
     * 经纪人列表
     *
     * @return void
     */
    public function brokerList()
    {
        $response = $this->dispatch(new CustomerJobs\BrokerListJob());
        return $response;
    }

    /**
     * 客户详情
     *
     * @return void
     */
    public function show($id)
    {
        $response = $this->dispatch(new CustomerJobs\ShowJob($id));
        return $response;
    }

    /**
     * 审核经纪人
     *
     * @return void
     */
    public function checkBrokerList(CustomerRequests\CheckBrokerListRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\CheckBrokerListJob($params));
        return $response;
    }

    /**
     * 经纪人审核详情
     *
     * @return void
     */
    public function checkBrokerDetail(int $id)
    {
        $response = $this->dispatch(new CustomerJobs\CheckBrokerDetailJob($id));
        return $response;
    }

    /**
     * 经纪人认证状态
     *
     * @return void
     */
    public function typeAuthStatus(CustomerRequests\TypeAuthStatusRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\TypeAuthStatusJob($params));
        return $response;
    }

    /**
     * 查询
     *
     * @return void
     */
    public function searchBroker(CustomerRequests\SearchBrokerRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\SearchBrokerJob($params));
        return $response;
    }
}
