<?php

namespace App\Jobs\Backend\Message;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class UpdateJob
{
    use Dispatchable, Queueable;
    /**
     * ID
     *
     * @var integer
     */
    private $id;
    private $title;
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
        $this->id = $params['id'];
        $this->title = isset($params['title']) ? $params['title'] : null;
        $this->content = isset($params['content']) ? $params['content'] : null;
        $this->start_time = isset($params['start_time']) ? $params['start_time'] : null;
        $this->status = isset($params['status']) ? $params['status'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = TableModels\Message::findOrFail($this->id);
        $message->title = $this->title;
        $message->content = $this->content;
        $message->start_time = $this->start_time;
        $message->status = $this->status;
        $res = $message->save();

        if ($res) {
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

