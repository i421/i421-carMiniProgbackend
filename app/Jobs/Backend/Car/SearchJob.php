<?php

namespace App\Jobs\Backend\Car;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class SearchJob
{
    use Dispatchable, Queueable;

    private $name;
    private $brand;
    private $min_price;
    private $max_price;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->name = isset($params['name']) ? $params['name'] : null;
        $this->brand = isset($params['brand']) ? $params['brand'] : null;
        $this->min_price = isset($params['min_price']) ? $params['min_price'] : 0;
        $this->max_price = isset($params['max_price']) ? $params['max_price'] : 99999999999;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = TableModels\Car::leftJoin('brands', 'cars.brand_id', '=', 'brands.id')
            ->select('cars.*', 'brands.name as brand_name');

        if (!is_null($this->name)) {
            $tempRes->where('cars.name', 'like', "%$this->name%");
        }
        
        if (!is_null($this->brand)) {
            $tempRes->where('cars.brand_id', $this->brand);
        }

        $tempRes->where([
            ['cars.car_price', '>=', $this->min_price],
            ['cars.car_price', '<=', $this->max_price],
        ]);

        $cars = $tempRes->get();

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
