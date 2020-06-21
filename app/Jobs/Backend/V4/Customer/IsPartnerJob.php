<?php

namespace App\Jobs\Backend\V4\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class IsPartnerJob
{
    use Dispatchable, Queueable;

    private $id;
    private $is_partner;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->id = $params['id'];
        $this->is_partner = $params['is_partner'];
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

        $customer->is_partner = $this->is_partner;
        $customer->save();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
        ];

        return response()->json($response);
    }
}
