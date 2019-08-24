<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use App\Tables as TableModels;

class UploadDrivingLicenseJob
{
    use Dispatchable, Queueable;

    private $openid;
    private $driver_license;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->openid = $params['openid'];
        $this->driver_license = $params['driver_license'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = TableModels\Customer::where("openid", $this->openid)->first();

        if (!empty($customer)) {

            $infoArr = json_decode($customer->getOriginal('info'), true);
            $infoArr['driver_license'] = $this->driver_license;
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
