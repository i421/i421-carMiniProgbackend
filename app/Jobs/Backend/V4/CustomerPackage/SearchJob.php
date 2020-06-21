<?php

namespace App\Jobs\Backend\V4\CustomerPackage;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class SearchJob
{
    use Dispatchable, Queueable;

    private $customer_nickname;
    private $customer_phone;
    private $package_name;
    private $page;
    private $pagesize;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->customer_phone = isset($params['customer_phone']) ? $params['customer_phone'] : null;
        $this->customer_nickname = isset($params['customer_nickname']) ? $params['customer_nickname'] : null;
        $this->package_name = isset($params['package_name']) ? $params['package_name'] : null;
        $this->pagesize = isset($params['pagesize']) ? $params['pagesize'] : 15;
        $this->page = isset($params['page']) ? $params['page'] : 1;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $temp = TableModels\CustomerPackage::join("customers", 'customer_package.customer_id', '=', 'customers.id')
            ->join("packages", 'customer_package.package_id', '=', 'packages.id')
            ->select('customers.nickname as customer_nickname', 'customers.phone as customer_phone', 'packages.name as package_name', 'customer_package.*');

        if (!is_null($this->customer_phone)) {
            $temp = $temp->where("customers.phone", '=', $this->customer_phone);
        }

        if (!is_null($this->package_name)) {
            $temp = $temp->where("packages.name", 'like', "%$this->package_name%");
        }

        if (!is_null($this->customer_nickname)) {
            $temp = $temp->where("customers.nickname", 'like', "%$this->customer_nickname%");
        }

        $total = $temp->count();

        $offset = ($this->page -1) * $this->pagesize;

        $res = $temp->take($this->pagesize)->offset($offset)->get();

        if (is_null($res)) {

            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);

        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $res,
            'total' => $total
        ];

        return response()->json($response);
    }
}
