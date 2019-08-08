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
        $imgUrl = $request->file('img_url');
        $imgType = $imgUrl->extension();
        $imgUrlFileName = date("YmdHis") . str_random(40) . ".$imgType";
        $imgUrlPath = $imgUrl->storeAs('shopImg', $imgUrlFileName, 'public');
        $params['img_url'] = $imgUrlPath;

        $licenseUrl = $request->file('license_url');
        $imgType = $licenseUrl->extension();
        $licenseUrlFileName = date("YmdHis") . str_random(40) . ".$imgType";
        $licenseUrlPath = $licenseUrl->storeAs('shopImg', $licenseUrlFileName, 'public');
        $params['license_url'] = $licenseUrlPath;
        $params['user_id'] = $request->user()->id;
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

        if ($request->hasFile('img_url')) {
            $imgUrl = $request->file('img_url');
            $imgType = $imgUrl->extension();
            $imgUrlFileName = date("YmdHis") . str_random(40) . ".$imgType";
            $imgUrlPath = $imgUrl->storeAs('shopImg', $imgUrlFileName, 'public');
            $params['img_url'] = $imgUrlPath;
        }

        if ($request->hasFile('license_url')) {
            $licenseUrl = $request->file('license_url');
            $imgType = $licenseUrl->extension();
            $licenseUrlFileName = date("YmdHis") . str_random(40) . ".$imgType";
            $licenseUrlPath = $licenseUrl->storeAs('shopImg', $licenseUrlFileName, 'public');
            $params['license_url'] = $licenseUrlPath;
        }

        $params['user_id'] = $request->user()->id;

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
     * Search a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(ShopRequests\SearchRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new ShopJobs\SearchJob($params));
        return $response;
    }
}
