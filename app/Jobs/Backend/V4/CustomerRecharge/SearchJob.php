<?php

namespace App\Jobs\Backend\V4\CustomerRecharge;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class SearchJob
{
    use Dispatchable, Queueable;

    private $customer_nickname;
    private $customer_phone;
    private $time;
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
        $this->time = isset($params['time']) ? $params['time'] : null;
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
        $temp = TableModels\CustomerRecharge::join("customers", 'customer_recharges.customer_id', '=', 'customers.id')
            ->select('customers.nickname as customer_nickname', 'customers.phone as customer_phone', 'customer_recharges.*');

        if (!is_null($this->customer_phone)) {
            $temp = $temp->where("customers.phone", '=', $this->customer_phone);
        }

        if (!is_null($this->customer_nickname)) {
            $temp = $temp->where("customers.nickname", 'like', "%$this->customer_nickname%");
        }

        if (!is_null($this->time)) {
            $temp = $temp->where([
                ['customer_recharges.created_at', '>=', $this->time[0]],
                ['customer_recharges.created_at', '<=', $this->time[1]],
            ]);
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
