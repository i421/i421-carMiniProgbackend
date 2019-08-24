<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use App\Tables as TableModels;

class UpdatePhoneJob
{
    use Dispatchable, Queueable;

    private $iv;
    private $encryptedData;
    private $openid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->openid = $params['openid'];
        $this->iv = $params['iv'];
        $this->encryptedData = $params['encryptedData'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $miniProgram = \EasyWeChat::miniProgram();
        $decryptedData = $miniProgram->encryptor->decryptData(Cache::get($this->openid), $this->iv, $this->encryptedData);

        \Log::info($decryptedData);

        $customer = TableModels\Customer::where("openid", $this->openid)->first();

        if (!empty($customer)) {
            $customer->phone = $decryptedData['phoneNumber'];
            $customer->save();
        } else {
            $response = [
                'code' => trans('pheicloud.response.error.code'),
                'msg' => trans('pheicloud.response.error.msg'),
                'data' => '',
            ];

            return response()->json($response);
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $decryptedData['phoneNumber'],
        ];

        return response()->json($response);
    }
}
