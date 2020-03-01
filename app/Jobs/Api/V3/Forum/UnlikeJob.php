<?php

namespace App\Jobs\Api\V3\Forum;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Forum;
use App\Tables\Customer;

class UnlikeJob
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

        $like_detail = $forum->like_detail;

        $temp = [];
        $flag = false;

        foreach($like_detail as $atom) {

            if ($atom["id"] == $this->customer_id) {
                $flag = true;
                break;
            } else {
                array_push($temp, $atom);
            }
        }

        if ($flag) {
            $forum->like_detail = $temp;
            $forum->like -= 1;
            $forum->save();

            $response = [
                'code' => trans('pheicloud.response.success.code'),
                'msg' => trans('pheicloud.response.success.msg'),
            ];
        } else {
            $response = [
                'code' => '80003',
                'msg' => '未点赞',
            ];
        }

        return response()->json($response);
    }
}
