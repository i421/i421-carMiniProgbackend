<?php

namespace App\Jobs\Api\V2\Shop;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class SecondHandCarJob
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
        $shops = TableModels\Shop::all()->toArray();
        $secondHandCars = TableModels\ShopSecondHandCar::all()->toArray();

        foreach ($shops as & $shop) {

            foreach ($secondHandCars as $secondHandCar) {

                if ($shop['id'] == $secondHandCar['shop_id']) {
                    $shop['cars'][] = $secondHandCar;
                }
            }
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $shops,
        ];

        return response()->json($response);
    }
}
