<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use App\Tables\Customer;

class AppcodeJob
{
    use Dispatchable, Queueable;

    private $openid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $openid)
    {
        $this->openid = $openid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $miniProgram = \EasyWeChat::miniProgram();

        $response = $miniProgram->app_code->getUnlimit("opend=$this->openid", [
            'page' => 'pages/index/index',
        ]);

        if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            $filename = $response->saveAs('app_code', 'appcode' . date("YmdHis") . '.png');
        }

        \Log::info($filename);

        Customer::where('openid', $this->openid)->update([
            'qr_code' => $filename
        ]);
        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $response,
        ];

        return response()->json($response);
    }
}
