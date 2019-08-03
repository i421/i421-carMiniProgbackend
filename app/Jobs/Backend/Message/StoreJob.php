<?php

namespace App\Jobs\Backend\Message;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class StoreJob
{
    use Dispatchable, Queueable;

    private $title;
    private $sub_title;
    private $content;
    private $status;
    private $start_time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->title = $params['title'];
        $this->sub_title = $params['sub_title'];
        $this->content = $params['content'];
        $this->status = isset($params['status']) ? $params['status'] : 0;
        $this->start_time = $params['start_time'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = TableModels\Message::create([
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'content' => $this->content,
            'status' => $this->status,
            'start_time' => $this->start_time,
        ]);

        if ($message) {

            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');

        } else {

            $code = trans('pheicloud.response.error.code');
            $msg = trans('pheicloud.response.error.msg');

        }

        $response = [
            'code' => $code,
            'msg' => $msg,
        ];

        return response()->json($response);
    }
}
