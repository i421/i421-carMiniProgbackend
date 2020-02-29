<?php

namespace App\Http\Controllers\Backend\V3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Backend\V3\Comment as CommentJobs;

class CommentController extends Controller
{
    /**
     * 禁止评论
     */
    public function ban($id)
    {
        $response = $this->dispatch(new CommentJobs\BanJob($id));
        return $response;
    }
}
