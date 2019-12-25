<?php

namespace App\Jobs\Backend\V3\Package;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateJob
{
    use Dispatchable, Queueable;

    private $id;
    private $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $params)
    {
        $this->id = $id;
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $res = TableModels\Package::where('id', $this->id)->update($this->params);

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
