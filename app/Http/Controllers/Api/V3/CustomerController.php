<?php

namespace App\Http\Controllers\Api\V3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V3\Customer as CustomerJobs;
use App\Http\Requests\Api\V3\Customer as CustomerRequests;

class CustomerController extends Controller
{
    public function __construct()
    {
        //
    }

    public function buyPackage(CustomerRequests\BuyPackageRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\BuyPackageJob($params));
        return $response;
    }

    public function writeOff(CustomerRequests\WriteOffRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\WriteOffJob($params));
        return $response;
    }
}
