<?php

namespace App\Jobs\Backend\V4\MallRecharge;

use App\Tables as TableModels;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class SearchJob
{
    use Dispatchable, Queueable;

    private $name;
    private $phone;
    private $agent;
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
        $this->name = isset($params['name']) ? $params['name'] : null;
        $this->phone = isset($params['phone']) ? $params['phone'] : null;
        $this->agent = isset($params['agent']) ? $params['agent'] : null;
        $this->time = isset($params['time']) ? $params['time'] : null;
        $this->page = isset($params['page']) ? $params['page'] : 1;
        $this->pagesize = isset($params['pagesize']) ? $params['pagesize'] : 10;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $upUsers = TableModels\Customer::pluck('nickname', 'id');
        $tempRes = TableModels\MallRecharge::leftJoin("customers", 'mall_recharges.customer_id', '=', 'customers.id')
            ->select('mall_recharges.*', 'customers.phone', 'customers.nickname', 'customers.recommender');

        if (!is_null($this->name) && !empty($this->name)) {
            $tempRes->where('customers.nickname', $this->name);
        }

        if (!is_null($this->phone) && !empty($this->phone)) {
            $tempRes->where('customers.phone', $this->phone);
        }

        if (!is_null($this->time) && !empty($this->time)) {
            $tempRes->where([
                ['mall_recharges.created_at', '>=', $this->time[0]],
                ['mall_recharges.created_at', '<=', $this->time[1]]
            ]);
        }

        $total = $tempRes->count();
        $mallRecharges = $tempRes->get();

        foreach($mallRecharges as &$mallRecharge) {
            if(isset($upUsers[$mallRecharge['recommender']])) {
                $mallRecharge['recommender'] = $upUsers[$mallRecharge['recommender']];
            } else {
                $mallRecharge['recommender'] = null;
            }
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallRecharges,
            'total' => $total,
        ];

        return response()->json($response);
    }
}
