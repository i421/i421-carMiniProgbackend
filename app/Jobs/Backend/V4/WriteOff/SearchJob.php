<?php

namespace App\Jobs\Backend\V4\WriteOff;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

class SearchJob
{
    use Dispatchable, Queueable;

    private $customer_phone;
    private $merchant_phone;
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
        $this->merchant_phone = isset($params['merchant_phone']) ? $params['merchant_phone'] : null;
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
        $totalSql = 'select
                    count(*) as count
	            from
                    (select * from customers) as customer1 
                right join 
                    write_offs on customer1.id = write_offs.customer_id 
                left join 
                    customers customer2 on customer2.id = write_offs.merchant_id where 1 ';

        $sql = 'select
                    write_offs.id as write_off_id, write_offs.created_at as write_off_created_at,
                    customer1.nickname as customer_nickname, customer2.nickname as merchant_nickname, write_offs.content, customer1.phone as customer_phone, customer2.phone as merchant_phone
	            from
                    (select * from customers) as customer1 
                right join 
                    write_offs on customer1.id = write_offs.customer_id 
                left join 
                    customers customer2 on customer2.id = write_offs.merchant_id where 1 ';

        if (!is_null($this->customer_phone)) {
            $sql .= "  and customer1.phone = '$this->customer_phone'";
            $totalSql .= " and customer1.phone = '$this->customer_phone'";
        }
        if (!is_null($this->merchant_phone)) {
            $sql .= " and customer2.phone = '$this->merchant_phone'";
            $totalSql .= " and customer2.phone = '$this->merchant_phone'";
        }

        $offset = ($this->page -1) * $this->pagesize;
        $sql .= "  limit $offset, $this->pagesize";

        $res = DB::select($sql);
        $total = DB::select($totalSql);

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
            'total' => $total[0]->count
        ];

        return response()->json($response);
    }
}
