<?php

namespace App\Jobs\Backend\V2\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class SecondHandCarListJob
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
        $shopSecondHandCars = TableModels\ShopSecondHandCar::leftJoin('shops', 'shop_second_hand_cars.shop_id', '=', 'shops.id')
            ->select("shop_second_hand_cars.*", 'shops.name as shop_name', 'shops.phone as shop_phone', 'shops.detail_address as shop_address')
            ->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $shopSecondHandCars,
        ];

        return response()->json($response);
    }
}
