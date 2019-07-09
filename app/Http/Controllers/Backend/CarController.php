<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Car as CarRequests;
use App\Jobs\Backend\Car as CarJobs;

class CarController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Car Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling restful user.
    */

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
     * 用户角色列表
     *
     * @return void
     */
    public function index()
    {
        $response = $this->dispatch(new CarJobs\IndexJob());
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarRequests\StoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CarJobs\StoreJob($params));
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
        $response = $this->dispatch(new CarJobs\ShowJob($id));
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(CarRequests\UpdateRequest $request, int $id)
    {
        $params = $request->all();
        $params['id'] = $id;
        $response = $this->dispatch(new CarJobs\UpdateJob($params));
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
        $response = $this->dispatch(new CarJobs\DestroyJob($id));
        return $response;
    }
}
