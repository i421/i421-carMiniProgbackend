<?php

namespace App\Jobs\Api\V3\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Forum;
use App\Tables\Comment;
use App\Tables\Customer;

class IndexJob
{
    use Dispatchable, Queueable;

    private $pagesize;
    private $page;
    private $customer_id;
    private $key_word;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pagesize, $page, $customer_id, $key_word)
    {
        $this->pagesize = $pagesize;
        $this->page = $page;
        $this->customer_id = $customer_id;
        $this->key_word = $key_word;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $total = Forum::count();
        if (is_null($this->key_word)) {
            $forums = Forum::where('status', 1)
                ->orderBy("top", 'desc')
                ->orderBy('updated_at', 'desc')
                ->offset(($this->page -1) * $this->pagesize)
                ->take($this->pagesize)
                ->get();
        } else {
            $forums = Forum::where('status', 1)
                ->where('title', 'like', "%$this->key_word%")
                ->orderBy("top", 'desc')
                ->orderBy('updated_at', 'desc')
                ->offset(($this->page -1) * $this->pagesize)
                ->take($this->pagesize)
                ->get();
        }

        $forumsId = []; 
        $customerIds = []; 

        foreach ($forums as $forum) {
            array_push($forumsId, $forum['id']);
            array_push($customerIds, $forum['customer_id']);
        }

        $customers = Customer::select('id', 'phone', 'nickname', 'openid', 'avatar')
            ->whereIn('id', $customerIds)
            ->get()
            ->toArray(); 

        $comments = Comment::select('forum_id', \DB::raw("count(*) as count"))
            ->where('status', 1)
            ->whereIn('forum_id', $forumsId)
            ->groupBy('forum_id')
            ->get()
            ->toArray(); 

        foreach ($forums as &$forum) {
            $forum['comment'] = 0;
            $forum['nickname'] = '';
            $forum['phone'] = '';
            $forum['avatar'] = '';

            $flag = 0;
            if (count($forum['like_detail']) > 0) {
                foreach ($forum['like_detail'] as $atom) {
                    if ($atom['id'] == $this->customer_id) {
                        $flag = 1;
                    }
                }
            }

            $forum['like_this'] = $flag;

            foreach($comments as $comment) {
                if ($forum['id'] == $comment['forum_id']) {
                    $forum['comment'] = $comment['count'];
                }
            }

            foreach($customers as $customer) {
                if ($customer['id'] == $forum['customer_id']) {
                    $forum['nickname'] = $customer['nickname'];
                    $forum['phone'] = $customer['phone'];
                    $forum['avatar'] = $customer['avatar'];
                }
            }
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $forums,
            'total' => $total,
        ];

        return response()->json($response);
    }
}
