<?php

namespace App\Jobs\Backend\Order;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class IndexJob
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = request()->user();
        $roles = $user->roles;

        $shops = [];

        foreach($roles as $role) {
            foreach ($role->info as $atom) {
                array_push($shops, $atom);
            }
        }

        $orders = TableModels\Order::leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoin('shops', 'orders.shop_id', '=', 'shops.id')
            ->leftJoin('cars', 'orders.car_id', '=', 'cars.id')
            ->select(
                'orders.*', 'cars.name as car_name', 'cars.final_price as final_price', 'cars.avatar as avatar', 'cars.type as type',
                'shops.name as shop_name', 'customers.info->name as customer_name', 'customers.phone as phone'
            )
            ->whereIn('shop_id', $shops)
            ->get()->toArray();

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
