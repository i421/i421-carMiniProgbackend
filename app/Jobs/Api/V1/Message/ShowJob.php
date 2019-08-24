<?php

namespace App\Jobs\Api\V1\Message;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TablesModels;

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
        $data = TablesModels\Message::find($this->id);

        if (is_null($data)) {
            $code = trans('pheicloud.response.notExist.code');
            $msg = trans('pheicloud.response.notExist.msg');
        } else {
            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');
        }

        $response = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];

        return response()->json($response);
    }
}
