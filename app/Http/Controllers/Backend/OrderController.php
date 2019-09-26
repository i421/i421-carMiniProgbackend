<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Order as OrderRequests;
use App\Jobs\Backend\Order as OrderJobs;

class OrderController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $response = $this->dispatch(new OrderJobs\IndexJob());
        return $response;
    }

    public function show($id)
    {
        $response = $this->dispatch(new OrderJobs\ShowJob($id));
        return $response;
    }

    public function search(OrderRequests\SearchRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new OrderJobs\SearchJob($params));
        return $response;
    }

    public function arrive(int $id)
    {
        $response = $this->dispatch(new OrderJobs\ArriveJob($id));
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $response = $this->dispatch(new OrderJobs\DestroyJob($id));
        return $response;
    }
}
