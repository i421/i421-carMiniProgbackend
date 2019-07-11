<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V1\Customer as CustomerJobs;

class CustomerController extends Controller
{
    public function __construct()
    {
        //
    }

    public function login(Request $request)
    {
        $code = $request->input('code');
        $response = $this->dispatch(new CustomerJobs\LoginJob($code));
        return $response;
    }
}
