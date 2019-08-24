<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FightingGroup as FightingGroupRequests;
use App\Jobs\Backend\FightingGroup as FightingGroupJobs;

class FightingGroupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('role:developer|admin');
    }

    /**
     * 列表
     *
     * @return void
     */
    public function index()
    {
        $response = $this->dispatch(new FightingGroupJobs\IndexJob());
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
        $response = $this->dispatch(new FightingGroupJobs\ShowJob($id));
        return $response;
    }

    /**
     * Search a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(FightingGroupRequests\SearchRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new FightingGroupJobs\SearchJob($params));
        return $response;
    }

    /**
     * Search a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(FightingGroupRequests\UpdateRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new FightingGroupJobs\UpdateJob($params));
        return $response;
    }
}
