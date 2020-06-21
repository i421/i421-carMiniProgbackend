<?php

namespace App\Http\Controllers\Api\V4;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V4\MallShoppingCart as MallShoppingCartJobs;
use App\Http\Requests\Api\V4\MallShoppingCart as MallShoppingCartRequests;

class MallShoppingCartController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * 购物车的列表
     */
    public function search()
    {
        $params = request()->all();
        $response = $this->dispatch(new MallShoppingCartJobs\SearchJob($params));
        return $response;
    }

    /**
     * 添加
     */
    public function store(MallShoppingCartRequests\StoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new MallShoppingCartJobs\StoreJob($params));
        return $response;
    }

    /**
     * 删除
     */
    public function destroy(int $id)
    {
        $response = $this->dispatch(new MallShoppingCartJobs\DestroyJob($id));
        return $response;
    }

    /**
     * 删除
     */
    public function changecount()
    {
        $params = request()->all();
        $response = $this->dispatch(new MallShoppingCartJobs\ChangecountJob($params));
        return $response;
    }
}
