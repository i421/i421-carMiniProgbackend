<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer as CustomerRequests;
use App\Jobs\Api\V1\Customer as CustomerJobs;

class CustomerController extends Controller
{
    public function __construct()
    {
        //
    }

    public function code2Session(Request $request)
    {
        $code = $request->input('code');
        $response = $this->dispatch(new CustomerJobs\Code2SessionJob($code));
        return $response;
    }

    public function store(CustomerRequests\StoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\StoreJob($params));
        return $response;
    }

    public function updatePhone(CustomerRequests\UpdatePhoneRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\UpdatePhoneJob($params));
        return $response;
    }
}
