<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
}
