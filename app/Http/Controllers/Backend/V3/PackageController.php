<?php

namespace App\Http\Controllers\Backend\V3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Backend\V3\Package as PackageJobs;
use App\Http\Requests\Backend\V3\Package as PackageRequests;

class PackageController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * 套餐列表
     */
    public function index()
    {
        $response = $this->dispatch(new PackageJobs\IndexJob());
        return $response;
    }

    /**
     * 查看套餐
     */
    public function show(int $id)
    {
        $response = $this->dispatch(new PackageJobs\ShowJob($id));
        return $response;
    }

    /**
     * 添加
     */
    public function store(PackageRequests\StoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new PackageJobs\StoreJob($params));
        return $response;
    }

    /**
     * 添加
     */
    public function update(int $id, PackageRequests\UpdateRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new PackageJobs\UpdateJob($id, $params));
        return $response;
    }

    /**
     * 删除套餐
     */
    public function destroy(int $id)
    {
        $response = $this->dispatch(new PackageJobs\DestroyJob($id));
        return $response;
    }
}
