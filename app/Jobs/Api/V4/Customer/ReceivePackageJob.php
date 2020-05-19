<?php

namespace App\Jobs\Api\V4\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use DB;

class ReceivePackageJob
{
    use Dispatchable, Queueable;

    private $id;
    private $package_id;
    private $customer_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $id, array $params)
    {
        $this->id = $id;
        $this->package_id = isset($params['package_id']) ? $params['package_id'] : '';
        $this->customer_id = isset($params['customer_id']) ? $params['customer_id'] : '';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customerPackage = DB::table("customer_package")->where([
            'customer_id', '=', $this->customer_id,
            'package_id', '=', $this->package_id,
        ])->first();

        if (is_null($customerPackage)) {
            $response = [
                'code' => '90001',
                'msg' => '领取失败',
            ];
            return response()->json($response);
        }

        $customerPackage->customer_id = $this->id;
        $customerPackage->qr_code = "customer_id=$id&package_id=$package_id";
        $customerPackage->save();

		$response = [
			'code' => trans('pheicloud.response.success.code'),
			'msg' => trans('pheicloud.response.success.msg'),
		];

		return response()->json($response);
    }
}
