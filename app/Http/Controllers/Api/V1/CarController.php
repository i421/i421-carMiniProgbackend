<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Car as CarRequests;
use App\Jobs\Api\V1\Car as CarJobs;

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
     * 汽车列表
     *
     * @return void
     */
    public function index()
    {
        $pagesize = request()->input('pagesize', 10);
        $response = $this->dispatch(new CarJobs\IndexJob($pagesize));
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
        $customer_id = request()->input('customer_id', null);
        $response = $this->dispatch(new CarJobs\ShowJob($id, $customer_id));
        return $response;
    }

    /**
     * 查询
     *
     * @return void
     */
    public function search(CarRequests\SearchRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CarJobs\SearchJob($params));
        return $response;
    }
}
