<?php

namespace App\Jobs\Backend\Car;

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
        $cars = TableModels\Car::leftJoin('brands', 'cars.brand_id', '=', 'brands.id')
            ->select('cars.*', 'brands.name as brand_name')
            ->get();

        $orders = TableModels\Order::select('car_id', DB::raw("count(*) as orders"))->where('payment_status', 1)->groupBy('car_id')->get();
        $collections = TableModels\Collection::select('car_id', DB::raw("count(*) as collections"))->groupBy('car_id')->get();

        foreach ($cars as & $car) {

            //初始化
            $car->order_count = 0;
            $car->collection_count = 0;

            foreach ($orders as $order) {
                if ($car->id == $order->car_id) {
                    $car->order_count = $order->orders;
                }
            }

            foreach ($collections as $collection) {
                if ($customer->id == $collection->car_id) {
                    $customer->collection_count = $collection->collections;
                }
            }
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $cars,
        ];

        return response()->json($response);
    }
}
