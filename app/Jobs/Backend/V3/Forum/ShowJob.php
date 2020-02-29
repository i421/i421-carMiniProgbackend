<?php

namespace App\Jobs\Backend\V3\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Forum;
use App\Tables\Comment;
use App\Tables\Customer;

class ShowJob
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
        $forum = Forum::find($this->id);

        $comments = Comment::where('forum_id', $this->id)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray(); 

        $customerIds = []; 

        foreach ($comments as $comment) {
            array_push($customerIds, $comment['customer_id']);
        }

        $customers = Customer::select('id', 'phone', 'nickname', 'openid')
            ->get()
            ->toArray(); 

        foreach($customers as $customer) {
            if ($customer['id'] == $forum->customer_id) {
                $forum->nickname = $customer['nickname'];
                $forum->phone = $customer['phone'];
            }
        }

        foreach ($comments as &$comment) {
            foreach($customers as $customer) {
                if ($customer['id'] == $comment['customer_id']) {
                    $comment['nickname'] = $customer['nickname'];
                    $comment['phone'] = $customer['phone'];
                }
            }
        }

        $forum['comments'] = $comments;

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $forum,
        ];

        return response()->json($response);
    }
}
