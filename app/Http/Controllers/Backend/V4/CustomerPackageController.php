<?php

namespace App\Http\Controllers\Backend\V4; 

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Backend\V4\CustomerPackage as CustomerPackageJobs;

class CustomerPackageController extends Controller
{
    public function __construct()
    {
        //
    }

    public function search()
    {
        $params = request()->all();
        $response = $this->dispatch(new CustomerPackageJobs\SearchJob($params));
        return $response;
    }
}
