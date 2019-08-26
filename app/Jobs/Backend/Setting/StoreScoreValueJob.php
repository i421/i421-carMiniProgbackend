<?php

namespace App\Jobs\Backend\Setting;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class StoreScoreValueJob
{
    use Dispatchable, Queueable;

    private $value;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
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

            $res = TableModels\Setting::create([
                'key' => 'score',
                'value' => json_encode([
		    'store' => $this->value[0],
		    'recommend' => $this->value[1],
		]),
            ]);

            if ($res) {
                $code = trans('pheicloud.response.success.code');
                $msg = trans('pheicloud.response.success.msg');
            } else {
                $code = trans('pheicloud.response.error.code');
                $msg = trans('pheicloud.response.error.msg');
            }

        } else {
            $code = trans('pheicloud.response.exist.code');
            $msg = trans('pheicloud.response.exist.msg');
        }

        $response = [
            'code' => $code,
            'msg' => $msg,
        ];

        return response()->json($response);
    }
}
