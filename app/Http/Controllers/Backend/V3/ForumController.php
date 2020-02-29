<?php

namespace App\Http\Controllers\Backend\V3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Backend\V3\Forum as ForumJobs;

class ForumController extends Controller
{
    /**
     * 帖子列表
     *
     * @return void
     */
    public function index()
    {
        $pagesize = request()->input('pagesize', 10);
        $page = request()->input('page', 1);
        $response = $this->dispatch(new ForumJobs\IndexJob($pagesize, $page));
        return $response;
    }

    /**
     * 查看帖子
     */
    public function show($id)
    {
        $response = $this->dispatch(new ForumJobs\ShowJob($id));
        return $response;
    }

    /**
     * 发布帖子
     */
    public function check($id)
    {
        $response = $this->dispatch(new ForumJobs\CheckJob($id));
        return $response;
    }

    /**
     * 置顶
     */
    public function top($id)
    {
        $response = $this->dispatch(new ForumJobs\TopJob($id));
        return $response;
    }

    /**
     * 删除帖子
     */
    public function destroy($id)
    {
        $response = $this->dispatch(new ForumJobs\DestroyJob($id));
        return $response;
    }

    /**
     * 删除帖子
     */
    public function search()
    {
        $params = request()->all();
        $response = $this->dispatch(new ForumJobs\SearchJob($params));
        return $response;
    }
}
