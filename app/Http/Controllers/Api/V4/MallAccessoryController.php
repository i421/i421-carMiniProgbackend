<?php

namespace App\Http\Controllers\Api\V4;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V4\MallAccessory as MallAccessoryJobs;

class MallAccessoryController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * 配件分类列表
     */
    public function index()
    {
        $response = $this->dispatch(new MallAccessoryJobs\IndexJob());
        return $response;
    }

    /**
     * 查看配件分类
     */
    public function show(int $id)
    {
        $response = $this->dispatch(new MallAccessoryJobs\ShowJob($id));
        return $response;
    }

    /**
     * 查看分类下的列表
     */
    public function classify(int $id)
    {
        $response = $this->dispatch(new MallAccessoryJobs\ClassifyJob($id));
        return $response;
    }

    /**
     * 搜索分类下的列表
     */
    public function search()
    {
        $params = request()->all();
        $response = $this->dispatch(new MallAccessoryJobs\SearchJob($params));
        return $response;
    }
}
