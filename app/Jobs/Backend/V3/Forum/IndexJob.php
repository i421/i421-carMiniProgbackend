<?php

namespace App\Jobs\Backend\V3\Forum;

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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pagesize, $page)
    {
        $this->pagesize = $pagesize;
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$forums = Forum::offset(($this->page -1) * $this->pagesize)->take($this->pagesize)->get();
        $forums = Forum::all();

        $forumsId = []; 
        $customerIds = []; 

        foreach ($forums as $forum) {
            array_push($forumsId, $forum['id']);
            array_push($customerIds, $forum['customer_id']);
        }

        $customers = Customer::select('id', 'phone', 'nickname', 'openid')
            ->whereIn('id', $customerIds)
            ->get()
            ->toArray(); 

        $comments = Comment::select('forum_id', \DB::raw("count(*) as count"))
            ->whereIn('forum_id', $forumsId)
            ->groupBy('forum_id')
            ->get()
            ->toArray(); 

        foreach ($forums as &$forum) {
            $forum['comment'] = 0;
            foreach($comments as $comment) {
                if ($forum['id'] == $comment['forum_id']) {
                    $forum['comment'] = $comment['count'];
                }
            }

            foreach($customers as $customer) {
                if ($customer['id'] == $forum['customer_id']) {
                    $forum['nickname'] = $customer['nickname'];
                    $forum['phone'] = $customer['phone'];
                }
            }
        }

        $total = Forum::count();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $forums,
            'total' => $total,
        ];

        return response()->json($response);
    }
}
