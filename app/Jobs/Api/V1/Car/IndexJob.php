<?php

namespace App\Jobs\Api\V1\Car;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class IndexJob
{
    use Dispatchable, Queueable;

    private $pagesize;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $pagesize)
    {
        $this->pagesize = $pagesize;
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
            ->orderBy("created_at", 'desc')
            ->paginate($this->pagesize);

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
                if ($car->id == $collection->car_id) {
                    $car->collection_count = $collection->collections;
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
