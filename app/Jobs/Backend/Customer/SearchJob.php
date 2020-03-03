<?php

namespace App\Jobs\Backend\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Tables as TableModels;
use DB;

class SearchJob
{
    use Dispatchable, Queueable;

    private $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = TableModels\Customer::select(
            'id', 'phone', 'nickname', 'openid', 'gender', 'recommend_count', 'status', 'auth', 'is_seller', 'created_at'
        );

        if (!is_null($this->params['phone']) && !empty($this->params['phone'])) {
            $tempRes->where('phone', $this->params['phone']);
        }

        if (!is_null($this->params['nickname']) && !empty($this->params['nickname'])) {
            $tempRes->where('nickname', $this->params['nickname']);
        }

        if (!is_null($this->params['time']) && count($this->params['time']) >= 1) {
            $tempRes->where([
                ['created_at', '>=', $this->params['time'][0] . ' 00:00:00'],
                ['created_at', '<=', $this->params['time'][1] . ' 23:59:59']
            ]);
        }

        if (count($this->params['auth']) >= 1) {
            $tempRes->whereIn('auth', $this->params['auth']);
        }

        if (is_array($this->params['is_seller'])) {
            if (count($this->params['is_seller']) >= 1) {
                $tempRes->whereIn('is_seller', $this->params['is_seller']);
            }
        }

        if (count($this->params['is_buyer']) == 1) {
            $customerIds = DB::table("customer_package")->pluck('customer_id');
            if ($this->params['is_buyer'][0] == 0) {
                $customers = $tempRes->whereNotIn("id", $customerIds)->get();
            } else {
                $customers = $tempRes->whereIn("id", $customerIds)->get();
            }
        } else {
            $customers = $tempRes->get();
        }

        //$customers = $tempRes->isNormal()->get();

        $scores = TableModels\Score::select('customer_id', DB::raw("sum(count) as scores"))->groupBy('customer_id')->get();
        $orders = TableModels\Order::select('customer_id', DB::raw("count(*) as orders"))->where('payment_status', 1)->groupBy('customer_id')->get();
        $collections = TableModels\Collection::select('customer_id', DB::raw("count(*) as collections"))->groupBy('customer_id')->get();

        foreach ($customers as & $customer) {

            //初始化
            $customer->score_count = 0;
            $customer->order_count = 0;
            $customer->collection_count = 0;

            foreach ($scores as $score) {
                if ($customer->id == $score->customer_id) {
                    $customer->score_count = $score->scores;
                }
            }
            foreach ($orders as $order) {
                if ($customer->id == $order->customer_id) {
                    $customer->order_count = $order->orders;
                }
            }
            foreach ($collections as $collection) {
                if ($customer->id == $collection->customer_id) {
                    $customer->collection_count = $collection->collections;
                }
            }
        }

		$this->params['pagesize'] = isset($this->params['pagesize']) ? $this->params['pagesize'] : 15;
        $temp = $this->paginate($customers, $this->params['pagesize']);
		$temp = object_to_array($temp);

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $temp,
        ];

        return response()->json($response);
    }

    public function paginate($items, $perPage = 15, $page = null, $baseUrl = null, $options = [])
    {
        $baseUrl = url()->current();

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ?  $items : Collection::make($items);

        $lap = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

        if ($baseUrl) {
            $lap->setPath($baseUrl);
        }

        return $lap;
    }

}
