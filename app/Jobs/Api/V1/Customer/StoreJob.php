<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use App\Events\Customer\StoreEvent;

class StoreJob
{
    use Dispatchable, Queueable;

    private $iv;
    private $openid;
    private $recommender;
    private $encryptedData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->iv = $params['iv'];
        $this->openid = $params['openid'];
        $this->encryptedData = $params['encryptedData'];
        $this->recommender = isset($params['recommender']) ? $params['recommender'] : '';
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

        //\Log::info($decryptedData);

        event(new StoreEvent($decryptedData, $this->recommender));

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $decryptedData,
        ];

        return response()->json($response);
    }
}
