<?php

namespace App\Jobs\Api\V3\Customer;

use App\Tables as TableModels;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class WriteOffJob
{
    use Dispatchable, Queueable;

    private $customer_id;
    private $package_id;
    private $merchant_id;
    private $time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->time = $params['time'];
        $this->customer_id = $params['customer_id'];
        $this->package_id = $params['package_id'];
        $this->merchant_id = $params['merchant_id'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (time() - $this->time > 70) {
            $response = [
                'code' => trans('pheicloud.response.outOfTime.code'),
                'msg' => trans('pheicloud.response.outOfTime.msg'),
            ];

            return response()->json($response);
        }

        $merchant = TableModels\Customer::find($this->merchant_id);
        if ($merchant->is_seller != 1) {
            $response = [
                'code' => trans('pheicloud.response.noPriviledges.code'),
                'msg' => trans('pheicloud.response.noPriviledges.msg'),
            ];

            return response()->json($response);
        }

        $customer_package = DB::table("customer_package")->where([
            ['customer_id', '=', $this->customer_id],
            ['package_id', '=', $this->package_id],
        ])->where('left_count', '>', '0')
        ->first();

        if (is_null($customer_package)) {
            $response = [
                'code' => trans('pheicloud.response.outOfLeftCount.code'),
                'msg' => trans('pheicloud.response.outOfLeftCount.msg'),
            ];
            return response()->json($response);
        }

        $diff = time() - strtotime($customer_package->updated_at);

        if ($diff < 30) {
            $response = [
                'code' => trans('pheicloud.response.tooClose.code'),
                'msg' => trans('pheicloud.response.tooClose.msg'),
            ];

            return response()->json($response);
        }

        DB::table("customer_package")->where('id', $customer_package->id)->decrement('left_count', 1);
        DB::table("customer_package")->where('id', $customer_package->id)->update([
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        \Log::info("merchant_id:$this->merchant_id" . "====" . "package_id=$this->package_id");

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
        ];

        return response()->json($response);
    }
}
