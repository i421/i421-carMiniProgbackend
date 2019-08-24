<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V1\Message as MessageJobs;

class MessageController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $response = $this->dispatch(new MessageJobs\IndexJob());
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $response = $this->dispatch(new MessageJobs\ShowJob($id));
        return $response;
    }
}
