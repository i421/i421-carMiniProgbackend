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
        $tempRes = TableModels\MallAccessoryOrder::leftJoin("mall_addresses", 'mall_accessory_orders.mall_address_id', '=', 'mall_addresses.id')
            ->leftJoin("customers", 'mall_accessory_orders.customer_id', '=', 'customers.id', 'customers.nickname as customer_nickname')
            ->select(
                'mall_accessory_orders.*', 'customers.gender as customer_gender',
                'customers.type as customer_type', 'mall_addresses.name as mall_address_name',
                'mall_addresses.phone as mall_address_phone', 'mall_addresses.detail_address as mall_address_detail'
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

        foreach ($mallAccessoryOrders as &$mallAccessoryOrder) {
            $mallAccessoryOrderIds = $mallAccessoryOrder->mall_accessory_id;
            $res = TableModels\MallAccessory::select("id", "name")->whereIn("id", $mallAccessoryOrderIds)->get()->toArray();
            $mallAccessoryOrder['mall_detail'] = $res;
        }

        unset($mallAccessoryOrder);

        foreach ($mallAccessoryOrders as $key => &$atom) {
            $temp = '';
            foreach ($atom->mall_accessory_id as $kk => $id) {
                foreach ($atom->mall_detail as $detail) {
                    if ($id == $detail['id']) {
                        $temp .= $detail['name'] . "数量";
                    }
                }

                $temp .= $atom->mall_accessory_count[$kk] . ';';

            }

            $atom['detail_all'] = $temp;
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallAccessoryOrders,
        ];

        return response()->json($response);
    }
}
