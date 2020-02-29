<?php

namespace App\Http\Controllers\Api\V3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V3\Forum as ForumRequests;
use App\Jobs\Api\V3\Forum as ForumJobs;

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
    public function store(ForumRequests\StoreRequest $request)
    {
        $params = $request->all();
        $params['imgs'] = explode(',', $params['imgs']);
        $response = $this->dispatch(new ForumJobs\StoreJob($params));
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
     * 点赞
     */
    public function like($id)
    {
        $response = $this->dispatch(new ForumJobs\LikeJob($id));
        return $response;
    }

    /**
     * 取消点赞
     */
    public function unlike($id)
    {
        $response = $this->dispatch(new ForumJobs\UnlikeJob($id));
        return $response;
    }
}
