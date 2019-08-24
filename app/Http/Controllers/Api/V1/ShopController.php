<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V1\Shop as ShopJobs;

class ShopController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Shop Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling restful shop.
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
        $response = $this->dispatch(new ShopJobs\IndexJob());
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
        $response = $this->dispatch(new ShopJobs\ShowJob($id));
        return $response;
    }
}
