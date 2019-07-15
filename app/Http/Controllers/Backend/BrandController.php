<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Brand as BrandRequests;
use App\Jobs\Backend\Brand as BrandJobs;

class BrandController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $response = $this->dispatch(new BrandJobs\IndexJob());
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
        $response = $this->dispatch(new BrandJobs\ShowJob($id));
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequests\UpdateRequest $request, int $id)
    {
        $params = $request->all();
        $params['id'] = $id;
        $response = $this->dispatch(new BrandJobs\UpdateJob($params));
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
        $response = $this->dispatch(new BrandJobs\DestroyJob($id));
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequests\StoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new BrandJobs\StoreJob($params));
        return $response;
    }
}