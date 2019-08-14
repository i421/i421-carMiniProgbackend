<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use App\Tables as TableModels;

class UploadBankcardJob
{
    use Dispatchable, Queueable;

    private $bank_card;
    private $uuid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->uuid = $params['uuid'];
        $this->bank_card = $params['bank_card'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = TableModels\Customer::where("uuid", $this->uuid)->first();

        if (!empty($customer)) {

            $infoArr = json_decode($customer->getOriginal('info'), true);
            $infoArr['bank_card'] = $this->bank_card;
            $customer->info = $infoArr;
            $customer->save();

        } else {

            $response = [
                'code' => trans('pheicloud.response.error.code'),
                'msg' => trans('pheicloud.response.error.msg'),
                'data' => [],
            ];

            return response()->json($response);

        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
        ];

        return response()->json($response);
    }
}
