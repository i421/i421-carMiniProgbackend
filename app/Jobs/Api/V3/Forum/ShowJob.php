<?php

namespace App\Jobs\Api\V3\Forum;

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
        $forum = Forum::join('customers', 'forums.customer_id', '=', 'customers.id')
                ->select('forums.*', 'avatar', 'nickname', 'phone')
                ->find($this->id);

        $comments = Comment::where('forum_id', $this->id)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray(); 

        $customerIds = []; 

        foreach ($comments as $comment) {
            array_push($customerIds, $comment['customer_id']);
        }

        $customers = Customer::select('id', 'phone', 'nickname', 'openid', 'avatar')
            ->whereIn('id', $customerIds)
            ->get()
            ->toArray(); 

        foreach ($comments as &$comment) {
            $comment['nickname'] = '';
            $comment['avatar'] = '';
            $comment['phone'] = '';
            foreach($customers as $customer) {
                if ($customer['id'] == $comment['customer_id']) {
                    $comment['nickname'] = $customer['nickname'];
                    $comment['avatar'] = $customer['avatar'];
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
