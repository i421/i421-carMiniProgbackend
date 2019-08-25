<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\FightingGroup as FightingGroupRequests;
use App\Jobs\Api\V1\FightingGroup as FightingGroupJobs;

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

    public function search(FightingGroupRequests\SearchRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new FightingGroupJobs\SearchJob($params));
        return $response;
    }

    //优惠拼团
    public function off()
    {
        $response = $this->dispatch(new FightingGroupJobs\OffJob());
        return $response;
    }
}
