<?php

namespace App\Http\Controllers\Backend\V4;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Backend\V4\MallAccessoryOrder as MallAccessoryOrderJobs;

class MallAccessoryOrderController extends Controller
{
    /**
     * 配件订单列表
     */
    public function index()
    {
        $page = request()->input('page', null);
        $pagesize = request()->input('pagesize', null);
        $status = request()->input('status', -1);
        $response = $this->dispatch(new MallAccessoryOrderJobs\IndexJob($pagesize, $page, $status));
        return $response;
    }

    /**
     * 查看配件订单分类
     */
    public function show(int $id)
    {
        $response = $this->dispatch(new MallAccessoryOrderJobs\ShowJob($id));
        return $response;
    }

    /**
     * 删除订单
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
}
