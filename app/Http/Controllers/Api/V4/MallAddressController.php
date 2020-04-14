<?php

namespace App\Http\Controllers\Api\V4;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V4\MallAddress as MallAddressJobs;
use App\Http\Requests\Backend\V4\MallAddress as MallAddressRequests;

class MallAddressController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * 消费列表
     */
    public function search()
    {
        $params = request()->all();
        $response = $this->dispatch(new MallAddressJobs\SearchJob($params));
        return $response;
    }

    /**
     * 添加
     */
    public function store(MallAddressRequests\StoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new MallAddressJobs\StoreJob($params));
        return $response;
    }

    /**
     * 更新
     */
    public function update(int $id, MallAddressRequests\UpdateRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new MallAddressJobs\UpdateJob($id, $params));
        return $response;
    }

    /**
     * 查看套餐
     */
    public function show(int $id)
    {
        $response = $this->dispatch(new MallAddressJobs\ShowJob($id));
        return $response;
    }

    /**
     * 删除套餐
     */
    public function destroy(int $id)
    {
        $response = $this->dispatch(new MallAddressJobs\DestroyJob($id));
        return $response;
    }
}
