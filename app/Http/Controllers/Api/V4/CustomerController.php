<?php

namespace App\Http\Controllers\Api\V4;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V4\Customer as CustomerRequests;
use App\Jobs\Api\V4\Customer as CustomerJobs;

class CustomerController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * appcode
     */
    public function packageAppcode(int $id)
    {
        $params = request()->all();
        $response = $this->dispatch(new CustomerJobs\PackageAppcodeJob($id, $params));
        return $response;
    }

    public function receivePackage(int $id)
    {
        $params = request()->all();
        $response = $this->dispatch(new CustomerJobs\ReceivePackageJob($id, $params));
        return $response;
    }
}
