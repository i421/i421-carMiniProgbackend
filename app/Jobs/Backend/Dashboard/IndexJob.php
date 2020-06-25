<?php

namespace App\Jobs\Backend\Dashboard;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

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
        $totalCustomer = TableModels\Customer::count();
        $authCustomer = TableModels\Customer::where('auth', '1')->count();

        $nowCar = TableModels\Order::leftJoin('cars', 'orders.car_id', '=', 'cars.id')->where('cars.type', 1)->count();
        $groupCar = TableModels\Order::leftJoin('cars', 'orders.car_id', '=', 'cars.id')->where('cars.type', 2)->count();

        $mallAccessoryOrder = TableModels\MallAccessoryOrder::select(\DB::raw("sum(pay_price) as price"), \DB::raw("count(*) as count"), "pay_type")
            ->where("status", ">=", "2")
            ->groupBy("pay_type")
            ->get()->toArray();

        $temp = [ 'count' => 0, 'price' => 0];
        foreach ($mallAccessoryOrder as $order) {
            if ($order['pay_type'] == 1) {
                $temp['count'] += $order['count'];
                $temp['price'] += $order['price'];
            } else {
                $temp['count'] += $order['count'];
                $temp['price'] += (int)($order['price'] /1.15);
            }
        }

        $data = [
            'total_customer' => $totalCustomer,
            'auth_customer' => $authCustomer,
            'wait_auth_customer' => $totalCustomer - $authCustomer,
            'now_car' => $nowCar,
            'group_car' => $groupCar,
            'mall_accessory_order' => $temp,
        ];


        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $data,
        ];

        return response()->json($response);
    }
}
