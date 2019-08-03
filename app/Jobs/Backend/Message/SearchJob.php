<?php

namespace App\Jobs\Backend\Message;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class SearchJob
{
    use Dispatchable, Queueable;

    private $time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->time = isset($params['time']) ? $params['time'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = TableModels\Message::select('id', 'title', 'sub_title', 'content', 'status', 'start_time');

        if (!is_null($this->time) && count($this->time) > 1) {
            $tempRes->where([
                ['created_at', '>=', $this->time[0] . ' 00:00:00'],
                ['created_at', '<=', $this->time[1] . ' 23:59:59']
            ]);
        }

        $messages = $tempRes->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $messages,
        ];

        return response()->json($response);
    }
}
