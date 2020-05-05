<?php

namespace App\Jobs\Backend\V4\MallAccessoryOrder;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class ShowJob
{
    use Dispatchable, Queueable;

    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mallAccessoryOrder = TableModels\MallAccessoryOrder::leftJoin('mall_accessories', 'mall_accessory_orders.mall_accessory_id', '=', 'mall_accessories.id')
            ->leftJoin("mall_addresses", 'mall_accessory_orders.mall_address_id', '=', 'mall_addresses.id')
            ->leftJoin("customers", 'mall_accessory_orders.customer_id', '=', 'customers.id', 'customers.nickname as customer_nickname')
            ->select(
                'mall_accessory_orders.*', 'mall_accessories.name as mall_accessory_name', 'customers.gender as customer_gender',
                'customers.nickname as customer_nickname', 'customers.is_agent as customer_agent',
                'customers.type as customer_type', 'mall_accessories.price as price', 'mall_accessories.score_price as score_price',
                'mall_accessories.avatar as mall_accessory_avatar', 'mall_addresses.name as mall_address_name',
                'mall_addresses.phone as mall_address_phone', 'mall_addresses.detail_address as mall_address_detail',
                'mall_addresses.city as mall_address_city'
            )->where('mall_accessory_orders.id', '=', $this->id)->first();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallAccessoryOrder,
        ];

        return response()->json($response);
    }
}
