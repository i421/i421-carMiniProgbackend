<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V1\Brand as BrandJobs;

class BrandController extends Controller
{
    /**
     * 品牌列表
     *
     * @return void
     */
    public function index()
    {
        $response = $this->dispatch(new BrandJobs\IndexJob());
        return $response;
    }

    /**
     * 查询接口
     *
     * @return void
     */
    public function search(string $key)
    {
        $response = $this->dispatch(new BrandJobs\SearchJob($key));
        return $response;
    }

    /**
     * 热门品牌
     *
     * @return void
     */
    public function hot()
    {
        $response = $this->dispatch(new BrandJobs\HotJob());
        return $response;
    }

    /**
     * 热门品牌
     *
     * @return void
     */
    public function car(int $brand_id)
    {
        $response = $this->dispatch(new BrandJobs\CarJob($brand_id));
        return $response;
    }
}
