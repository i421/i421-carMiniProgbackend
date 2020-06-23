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
        $mallAccessoryOrder = TableModels\MallAccessoryOrder::leftJoin("mall_addresses", 'mall_accessory_orders.mall_address_id', '=', 'mall_addresses.id')
            ->leftJoin("customers", 'mall_accessory_orders.customer_id', '=', 'customers.id', 'customers.nickname as customer_nickname')
            ->select(
                'mall_accessory_orders.*', 'customers.gender as customer_gender', 'customers.phone as customer_phone',
                'customers.nickname as customer_nickname', 'customers.is_agent as customer_agent', 'customers.type as customer_type',
                'mall_addresses.phone as mall_address_phone', 'mall_addresses.detail_address as mall_address_detail',
                'mall_addresses.name as mall_address_name', 'mall_addresses.city as mall_address_city'
            )->where('mall_accessory_orders.id', '=', $this->id)->first();


        if (is_null($mallAccessoryOrder)) {
            $response = [
                'code' => trans('pheicloud.response.error.code'),
                'msg' => trans('pheicloud.response.error.msg'),
                'data' => [],
            ];

            return response()->json($response);
        }

        $mallAccessoryIds = $mallAccessoryOrder->mall_accessory_id;
        $mallAccessoryCounts = $mallAccessoryOrder->mall_accessory_count;

        $mallAccessories = TableModels\MallAccessory::whereIn('id', $mallAccessoryIds)->get()->toArray();

        for ($i = 0; $i < count($mallAccessories); $i++) {
            $mallAccessories[$i]['buy_count'] = $mallAccessoryCounts[$i];
        }

        $mallAccessoryOrder['mall_accessories'] = $mallAccessories;

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallAccessoryOrder,
        ];

        return response()->json($response);
    }
}
