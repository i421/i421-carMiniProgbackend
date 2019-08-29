<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Order as OrderRequests;
use App\Jobs\Api\V1\Order as OrderJobs;

class OrderController extends Controller
{
    public function __construct()
    {
        //
    }

    public function search(OrderRequests\SearchRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new OrderJobs\SearchJob($params));
        return $response;
    }
}
