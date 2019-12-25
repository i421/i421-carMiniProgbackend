<?php

namespace App\Jobs\Api\V3\Package;

use App\Tables as TableModels;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrcodeJob
{
    use Dispatchable, Queueable;

    private $customer_id;
    private $package_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params)
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
        $customer_package = DB::table("customer_package")->where([
            ['customer_id', '=', $this->customer_id],
            ['package_id', '=', $this->package_id],
        ])->first();

        $param = $customer_package->qr_code . '&time=' . time();

        $qr_code_name = storage_path('app/public/qrcodes/') . $this->customer_id . '_' . $this->package_id . '.png';

        $qr_code = QrCode::format('png')->size(200)->generate($param, $qr_code_name);

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => url('/') . '/storage/qrcodes/' . $this->customer_id  . '_' . $this->package_id . '.png',
        ];

        return response()->json($response);
    }
}
