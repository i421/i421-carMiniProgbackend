<?php

namespace App\Jobs\Api\V3\Package;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class CustomerJob
{
    use Dispatchable, Queueable;

    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = TableModels\Customer::find($this->id);

        if (is_null($customer)) {
            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];
            return response()->json($response);
        }

        $packages = $customer->packages;

        foreach($packages as & $package) {
            $package->left_count = $package->pivot->left_count;
            $package->qr_code = $package->pivot->qr_code;
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $packages,
        ];

        return response()->json($response);
    }
}
