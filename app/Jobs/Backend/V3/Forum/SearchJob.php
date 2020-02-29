<?php

namespace App\Jobs\Backend\V3\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Forum;
use App\Tables\Comment;
use App\Tables\Customer;

class SearchJob
{
    use Dispatchable, Queueable;

    private $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = Forum::select('*');
        if (isset($this->params['time']) && count($this->params['time']) >= 1) {
            $tempRes->where([
                ['created_at', '>=', $this->params['time'][0] . ' 00:00:00'],
                ['created_at', '<=', $this->params['time'][1] . ' 23:59:59']
            ]);
        }

        if (isset($this->params['top']) && count($this->params['top']) >= 1) {
            $tempRes->whereIn('top', $this->params['top']);
        }

        $forums = $tempRes->get();

        if (isset($this->params['nickname'])) {

            $customer = Customer::select('id', 'phone', 'nickname', 'openid')
                ->where('nickname', $this->params['nickname'])
                ->first()
                ->toArray(); 

            $tempForum = [];
            foreach ($forums as &$forum) {
                if ($forum['customer_id'] == $customer['id']) {
                    array_push($tempForum, $forum);
                }
            }
            $forums = $tempForum;
        }

        $forumIds = []; 

        foreach ($forums as $forum) {
            array_push($forumIds, $forum['id']);
        }

        $comments = Comment::select('forum_id', \DB::raw("count(*) as count"))
            ->whereIn('forum_id', $forumIds)
            ->groupBy('forum_id')
            ->get()
            ->toArray(); 

        /*
        $customerIds = []; 

        foreach ($comments as $comment) {
            array_push($customerIds, $comment['customer_id']);
        }
         */

        $customers = Customer::select('id', 'phone', 'nickname', 'openid')->get()
            ->toArray(); 

        /*
        foreach ($forums as &$forum) {

            foreach($customers as $customer) {
                if ($customer['id'] == $forum['customer_id']) {
                    $forum['nickname'] = $customer['nickname'];
                    $forum['phone'] = $customer['phone'];
                }
            }

            foreach ($comments as &$comment) {
                if ($forum['id'] == $comment['customer_id']) {
                    foreach($customers as $customer) {
                        if ($customer['id'] == $comment['customer_id']) {
                            $comment['nickname'] = $customer['nickname'];
                            $comment['phone'] = $customer['phone'];
                        }
                    }
                }

                //$forum['comments'] = $comments;
                $forum['comment'] = $comment['count'];
            }
        }
         */

        foreach ($forums as &$forum) {

            foreach($customers as $customer) {
                if ($customer['id'] == $forum['customer_id']) {
                    $forum['nickname'] = $customer['nickname'];
                    $forum['phone'] = $customer['phone'];
                }
            }

            $forum['comment'] = 0;
            foreach ($comments as &$comment) {
                if ($forum['id'] == $comment['forum_id']) {
                    $forum['comment'] = $comment['count'];
                }
            }
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $forums,
        ];

        return response()->json($response);
    }
}
