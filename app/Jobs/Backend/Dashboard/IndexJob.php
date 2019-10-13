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

        $data = [
            'total_customer' => $totalCustomer,
            'auth_customer' => $authCustomer,
            'wait_auth_customer' => $totalCustomer - $authCustomer,
            'now_car' => $nowCar,
            'group_car' => $groupCar,
        ];

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $data,
        ];

        return response()->json($response);
    }
}
