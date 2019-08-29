<?php

namespace App\Jobs\Api\V1\Order;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class SearchJob
{
    use Dispatchable, Queueable;

    private $order_no;
    private $phone;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->phone = isset($params['phone']) ? $params['phone'] : null;
        $this->order_no = isset($params['order_no']) ? $params['order_no'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = TableModels\Order::leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoin('shops', 'orders.shop_id', '=', 'shops.id')
            ->leftJoin('cars', 'orders.car_id', '=', 'cars.id')
            ->select(
                'orders.*', 'cars.name as car_name', 'cars.final_price as final_price', 'cars.avatar as avatar', 'cars.type as type',
                'shops.name as shop_name', 'customers.info->name as customer_name', 'customers.phone as phone'
            );

        if (!is_null($this->phone) && !empty($this->phone)) {
            $tempRes->where('customers.phone', $this->phone);
        }

        if (!is_null($this->order_no) && !empty($this->order_no)) {
            $tempRes->where('orders.order_num', $this->order_no);
        }

        $orders = $tempRes->get();

        foreach ($orders as &$order) {
            $order['avatar'] = 'storage/' . $order['avatar']; 
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $orders,
        ];

        return response()->json($response);
    }
}
