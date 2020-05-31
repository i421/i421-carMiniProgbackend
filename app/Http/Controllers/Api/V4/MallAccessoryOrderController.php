<?php

namespace App\Http\Controllers\Api\V4;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V4\MallAccessoryOrder as MallAccessoryOrderJobs;

class MallAccessoryOrderController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * 查看订单分类
     */
    public function show(int $id)
    {
        $response = $this->dispatch(new MallAccessoryOrderJobs\ShowJob($id));
        return $response;
    }

    /**
     * 删除订单分类
     */
    public function destroy(int $id)
    {
        $response = $this->dispatch(new MallAccessoryOrderJobs\DestroyJob($id));
        return $response;
    }

    /**
     * 查询
     */
    public function search()
    {
        $params = request()->all();
        $response = $this->dispatch(new MallAccessoryOrderJobs\SearchJob($params));
        return $response;
    }

    /**
     * 更新状态
     */
    public function toggleStatus()
    {
        $params = request()->all();
        $response = $this->dispatch(new MallAccessoryOrderJobs\ToggleStatusJob($params));
        return $response;
    }

    /**
     * 更新状态
     */
    public function updateExpress()
    {
        $params = request()->all();
        $response = $this->dispatch(new MallAccessoryOrderJobs\UpdateExpressJob($params));
        return $response;
    }
}
