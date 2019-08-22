<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use App\Tables\Customer;

class Code2SessionJob
{
    use Dispatchable, Queueable;

    private $code;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $miniProgram = \EasyWeChat::miniProgram();
        $res = $miniProgram->auth->session($this->code);

        if (isset($res['errcode'])) {

            $response = [
                'code' => trans('pheicloud.response.error.code'),
                'msg' => trans('pheicloud.response.error.msg'),
                'data' => '',
            ];

            \Log::info("[code2session]: " . json_encode($res));

            return response()->json($response);

        }

        \Log::info($res);

        Cache::forever($res['openid'], $res['session_key']);

        $customer = Customer::where('openid', $res['openid'])->first();

        if (is_null($customer)) {
            Customer::create([
                'uuid' => time() . str_random(30),
                'openid' => $res['openid'],
            ]);
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $res['openid'],
        ];

        return response()->json($response);
    }
}
