<?php

namespace App\Jobs\Api\V4\MallAddress;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class SearchJob
{
    use Dispatchable, Queueable;

    private $page;
    private $pagesize;
    private $customer_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->pagesize = isset($params['pagesize']) ? $params['pagesize'] : 10;
        $this->page = isset($params['page']) ? $params['page'] : 1;
        $this->customer_id = isset($params['customer_id']) ? $params['customer_id'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (is_null($this->customer_id)) {

            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);
        }

        $temp = TableModels\MallAddress::leftJoin('customers', 'mall_addresses.customer_id', '=', 'customers.id')
            ->select("mall_addresses.*")
            ->where('customer_id', '=', $this->customer_id);

        $count = $temp->count();

        $mallAddress = $temp->take($this->pagesize)
            ->offset(($this->page - 1) * $this->pagesize)
            ->get();

        if (is_null($mallAddress)) {
            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallAddress,
            'total' => $count,
        ];

        return response()->json($response);
    }
}
