<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Shop as ShopRequests;
use App\Jobs\Backend\Shop as ShopJobs;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopRequests\StoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new ShopJobs\StoreJob($params));
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(ShopRequests\UpdateRequest $request, int $id)
    {
        $params = $request->all();
        $params['id'] = $id;
        $response = $this->dispatch(new ShopJobs\UpdateJob($params));
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
        $response = $this->dispatch(new ShopJobs\DestroyJob($id));
        return $response;
    }

    /**
     * Get user shops
     *
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $response = $this->dispatch(new ShopJobs\UserJob($user));
        return $response;
    }
}
