<?php

namespace App\Jobs\Api\V3\Customer;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BuyPackageJob
{
    use Dispatchable, Queueable;

    private $customer_id;
    private $package_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->customer_id = $params['customer_id'];
        $this->package_id = $params['package_id'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = TableModels\Customer::find($this->customer_id);
        $package = TableModels\Package::find($this->package_id);

        $qr_code_name = storage_path('app/public/qrcodes/' . time() . '_' . $this->customer_id . '_' . $this->package_id) . '.png';

        $qr_code = QrCode::format('png')->size(200)->generate('https://www.baidu.com', $qr_code_name);

        // 购买套餐 付款
        $price = $package->price;

        // 保存套餐
        $customer->packages()->attach($this->package_id, [
            'left_count' => $package->maintenance_count,
            'qr_code' => $qr_code_name,
        ]);

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
        ];

        return response()->json($response);
    }
}
