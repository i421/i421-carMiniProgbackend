<?php

namespace App\Http\Controllers\Api\V3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V3\Comment as CommentRequests;
use App\Jobs\Api\V3\Comment as CommentJobs;

class CommentController extends Controller
{
    /**
     * 发布评论
     */
    public function store(CommentRequests\StoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CommentJobs\StoreJob($params));
        return $response;
    }

    /**
     * 删除评论
     */
    public function destroy($id)
    {
        $response = $this->dispatch(new CommentJobs\DestroyJob($id));
        return $response;
    }
}
