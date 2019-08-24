<?php

namespace App\Jobs\Backend\Setting;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class GetScoreJob
{
    use Dispatchable, Queueable;

    private $key;
    private $value;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->key = $params['key'];
        $this->value = $params['value'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $score = TableModels\Setting::where('key', 'score')->first();

        if (is_null($score)) {

            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');
            $temp = ['store' => 100, 'recommder' => 100];
            $data = json_encode($temp);

        } else {

            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');
            $temp = ['store' => 100, 'recommder' => 100];
            $data = is_null(json_decode($score->value, true)) ? $temp : json_decode($score->value, true);
        }

        $response = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];

        return response()->json($response);
    }
}
