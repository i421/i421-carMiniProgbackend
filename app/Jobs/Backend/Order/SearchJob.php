<?php

namespace App\Jobs\Backend\Order;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class SearchJob
{
    use Dispatchable, Queueable;

    private $order_no;
    private $phone;
    private $status;
    private $time;
    private $car_name;
    private $customer_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->customer_name = isset($params['customer_name']) ? $params['customer_name'] : null;
        $this->phone = isset($params['phone']) ? $params['phone'] : null;
        $this->order_no = isset($params['order_no']) ? $params['order_no'] : null;
        $this->time = isset($params['time']) ? $params['time'] : null;
        $this->car_name = isset($params['car_name']) ? $params['car_name'] : null;
        $this->status = isset($params['status']) ? $params['status'] : null;
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

        if (!is_null($this->customer_name) && !empty($this->customer_name)) {
            $tempRes->where('customers.info->name', $this->customer_name);
        }

        if (!is_null($this->car_name) && !empty($this->car_name)) {
            $tempRes->where('cars.name', $this->car_name);
        }

        if (!is_null($this->order_no) && !empty($this->order_no)) {
            $tempRes->where('orders.order_num', $this->order_no);
        }

        if (!is_null($this->status) && !empty($this->status)) {
            $tempRes->where('orders.status', $this->status);
        }

        if (!is_null($this->time) && count($this->time) >= 1) {
            $tempRes->where([
                ['orders.created_at', '>=', $this->time[0] . ' 00:00:00'],
                ['orders.created_at', '<=', $this->time[1] . ' 23:59:59']
            ]);
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
