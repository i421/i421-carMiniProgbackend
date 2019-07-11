<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Customer as CustomerRequests;
use App\Jobs\Backend\Customer as CustomerJobs;

class CustomerController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * 客户列表
     *
     * @return void
     */
    public function index()
    {
        $response = $this->dispatch(new CustomerJobs\IndexJob());
        return $response;
    }

    /**
     * 客户详情
     *
     * @return void
     */
    public function show($id)
    {
        $response = $this->dispatch(new CustomerJobs\ShowJob());
        return $response;
    }

    /**
     * 审核
     *
     * @return void
     */
    public function checkList(CustomerRequests\CheckListRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\CheckListJob($params));
        return $response;
    }

    /**
     * 审核详情
     *
     * @return void
     */
    public function checkDetail(int $id)
    {
        $response = $this->dispatch(new CustomerJobs\CheckDetailJob($id));
        return $response;
    }
}
