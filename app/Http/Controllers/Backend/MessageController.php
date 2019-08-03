<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Message as MessageRequests;
use App\Jobs\Backend\Message as MessageJobs;

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(MessageRequests\UpdateRequest $request, int $id)
    {
        $params = $request->all();
        $params['id'] = $id;
        $response = $this->dispatch(new MessageJobs\UpdateJob($params));
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
        $response = $this->dispatch(new MessageJobs\DestroyJob($id));
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequests\StoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new MessageJobs\StoreJob($params));
        return $response;
    }

    /**
     * Search
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(MessageRequests\SearchRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new MessageJobs\SearchJob($params));
        return $response;
    }
}
