<?php

namespace App\Jobs\Backend\V4\MallAccessoryOrder;

use App\Tables as TableModels;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class SearchJob
{
    use Dispatchable, Queueable;

    private $name;
    private $phone;
    private $order_no;
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
        $this->uuid = isset($params['order_no']) ? $params['order_no'] : null;
        $this->time = isset($params['time']) ? $params['time'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = TableModels\MallAccessoryOrder::leftJoin('mall_accessories', 'mall_accessory_orders.mall_accessory_id', '=', 'mall_accessories.id')
            ->leftJoin("mall_addresses", 'mall_accessory_orders.mall_address_id', '=', 'mall_addresses.id')
            ->leftJoin("customers", 'mall_accessory_orders.customer_id', '=', 'customers.id', 'customers.nickname as customer_nickname')
            ->select(
                'mall_accessory_orders.*', 'mall_accessories.name as mall_accessory_name', 'customers.gender as customer_gender',
                'customers.type as customer_type', 'mall_accessories.price as price', 'mall_accessories.score_price as score_price',
                'mall_accessories.avatar as mall_accessory_avatar', 'mall_addresses.name as mall_address_name',
                'mall_addresses.phone as mall_address_phone', 'mall_addresses.detail_address as mall_address_detail',
            );

        if (!is_null($this->name) && !empty($this->name)) {
            $tempRes->where('customers.nickname', $this->name);
        }

        if (!is_null($this->phone) && !empty($this->phone)) {
            $tempRes->where('customers.phone', $this->phone);
        }

        if (!is_null($this->time) && !empty($this->time)) {
            $tempRes->where([
                ['mall_accessory_orders.created_at', '>=', $this->time[0]],
                ['mall_accessory_orders.created_at', '<=', $this->time[1]]
            ]);
        }

        $mallAccessoryOrders = $tempRes->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallAccessoryOrders,
        ];

        return response()->json($response);
    }
}
