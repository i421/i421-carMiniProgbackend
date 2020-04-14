<?php

namespace App\Http\Controllers\Api\V4;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V4\MallAccessoryClassify as MallAccessoryClassifyJobs;

class MallAccessoryClassifyController extends Controller
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
        $response = $this->dispatch(new MallAccessoryClassifyJobs\IndexJob());
        return $response;
    }

    /**
     * 查看配件分类
     */
    public function show(int $id)
    {
        $response = $this->dispatch(new MallAccessoryClassifyJobs\ShowJob($id));
        return $response;
    }

    /**
     * 一级分类
     */
    public function primaryClassify()
    {
        $response = $this->dispatch(new MallAccessoryClassifyJobs\PrimaryClassifyJob());
        return $response;
    }

    /**
     * 查看某一级分类
     */
    public function showPrimaryTree($id)
    {
        $response = $this->dispatch(new MallAccessoryClassifyJobs\ShowPrimaryTreeJob($id));
        return $response;
    }
}
