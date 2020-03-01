<?php

namespace App\Jobs\Api\V3\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Forum;
use App\Tables\Comment;

class DestroyJob
{
    use Dispatchable, Queueable;

    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $comments = Comment::where('forum_id', $this->id)->delete();
        $forum = Forum::where('id', $this->id)->delete();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $forum,
        ];

        return response()->json($response);
    }
}
