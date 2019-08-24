<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\OrderMessage as OrderMessageRequests;
use App\Jobs\Api\V1\OrderMessage as OrderMessageJobs;

class OrderMessageController extends Controller
{
    public function __construct()
    {
        //
    }

    public function search(OrderMessageRequests\SearchRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new OrderMessageJobs\SearchJob($params));
        return $response;
    }
}
