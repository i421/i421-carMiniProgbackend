<?php

namespace App\Jobs\Api\V3\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Forum;
use App\Tables\Customer;

class LikeJob
{
    use Dispatchable, Queueable;

    private $id;
    private $customer_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $customer_id)
    {
        $this->id = $id;
        $this->customer_id = $customer_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = Customer::select('id','nickname','phone')->find($this->customer_id)->toArray();
        $forum = Forum::where('id', $this->id)->first();

        if (is_null($forum->like_detail)) {
            $forum->like_detail = [$customer];
            $forum->like += 1;
            $forum->save();
        } else {
            $like_detail = $forum->like_detail;

            $temp_id = [];
            foreach($like_detail as $atom) {
                array_push($temp_id, $atom["id"]);
            }

            if (!in_array($this->customer_id, $temp_id)) {
                $temp = $forum->like_detail;
                $tempCustomer = array_push($temp, $customer);
                $forum->like_detail = $temp;
                $forum->like += 1;
                $forum->save();

                $response = [
                    'code' => trans('pheicloud.response.success.code'),
                    'msg' => trans('pheicloud.response.success.msg'),
                ];
            } else {
                $response = [
                    'code' => "80005",
                    'msg' => "已经点赞",
                ];

            }

            return response()->json($response);
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $forum,
        ];

        return response()->json($response);
    }
}
