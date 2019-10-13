<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ShopRepair as ShopRepairRequests;
use App\Jobs\Api\V1\ShopRepair as ShopRepairJobs;

class ShopRepairController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ShopRepaire Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling restful ShopRepaire.
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
     * 维修点列表
     *
     * @return void
     */
    public function index()
    {
        $response = $this->dispatch(new ShopRepairJobs\IndexJob());
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopRepairRequests\StoreRequest $request)
    {
        $params = $request->all();
        $imgUrl = $request->file('img');
        $imgType = $imgUrl->extension();
        $imgUrlFileName = date("YmdHis") . str_random(40) . ".$imgType";
        $imgUrlPath = $imgUrl->storeAs('shopRepairImg', $imgUrlFileName, 'public');
        $params['img'] = $imgUrlPath;

        $response = $this->dispatch(new ShopRepairJobs\StoreJob($params));
        return $response;
    }

    public function search(ShopRepairRequests\SearchRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new ShopRepairJobs\SearchJob($params));
        return $response;
    }
}
