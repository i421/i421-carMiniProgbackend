<?php

namespace App\Jobs\Api\V4\MallAccessoryOrder;

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

        $temp = TableModels\MallAccessoryOrder::where('customer_id', '=', $this->customer_id)
                ->where('customer_id', '=', $this->customer_id);

        $count = $temp->count();

        $mallAccessoryOrders = $temp->orderBy("created_at", 'desc')->take($this->pagesize)
            ->offset(($this->page - 1) * $this->pagesize)
            ->get();

        foreach ($mallAccessoryOrders as &$order) {
            $res = TableModels\MallAccessory::select('id', 'name', 'price', 'score_price', 'avatar')->whereIn("id", $order->mall_accessory_id)->get()->toArray();
            $order['mall_accessory_detail'] = $res;
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallAccessoryOrders,
            'total' => $count,
        ];

        return response()->json($response);
    }
}
