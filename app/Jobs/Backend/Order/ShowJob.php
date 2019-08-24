<?php

namespace App\Jobs\Backend\Order;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

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
        $order = TableModels\Order::leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoin('shops', 'orders.shop_id', '=', 'shops.id')
            ->leftJoin('cars', 'orders.car_id', '=', 'cars.id')
            ->select(
                'orders.*', 'cars.name as car_name', 'cars.final_price as final_price', 'cars.avatar as avatar', 'cars.car_price as car_price',
                'cars.type as type',  'cars.group_type as group_type', 'cars.group_price as group_price', 'cars.total_num as total_num',
                'cars.current_num as current_num', 'cars.start_time as start_time', 'cars.end_time as end_time',
                'shops.name as shop_name', 'customers.info->name as customer_name', 'customers.phone as phone', 'customers.gender as customer_gender'
            )->where('orders.id', $this->id)
            ->get()
            ->toArray();

        $order[0]['avatar'] = 'storage/' . $order[0]['avatar'];


        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $order[0],
        ];

        return response()->json($response);
    }
}
