<?php

namespace App\Http\Controllers\Backend\V4; 

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\V4\Customer as CustomerRequests;
use App\Jobs\Backend\V4\Customer as CustomerJobs;

class CustomerController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * 是否代理人
     *
     * @return void
     */
    public function isAgent(CustomerRequests\IsAgentRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\IsAgentJob($params));
        return $response;
    }

    /**
     * 合作商家
     *
     * @return void
     */
    public function isPartner(CustomerRequests\IsPartnerRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\IsPartnerJob($params));
        return $response;
    }
}
