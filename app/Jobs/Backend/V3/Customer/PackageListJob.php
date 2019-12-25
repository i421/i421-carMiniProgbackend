<?php

namespace App\Jobs\Backend\V3\Customer;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class PackageListJob
{
    use Dispatchable, Queueable;

    private $params;
    private $phone;
    private $nickname;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->phone = isset($params['phone']) ? $params['phone'] : null; 
        $this->nickname = isset($params['nickname']) ? $params['nickname'] : null; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = TableModels\Customer::has("packages");

        if (!is_null($this->phone)) {
            $tempRes->where('phone', $this->phone);
        }

        if (!is_null($this->nickname)) {
            $tempRes->where('nickname', $this->nickname);
        }

        $customers = $tempRes->get();

        foreach ($customers as &$customer) {
            $customer->packages;
        }

        if (is_null($customers)) {
            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($responses);
        }


        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $customers,
        ];

        return response()->json($response);
    }
}
