<?php

namespace App\Jobs\Backend\V2\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class ShowSecondHandCarJob
{
    use Dispatchable, Queueable;

    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id)
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
        $shopSecondHandCar = TableModels\ShopSecondHandCar::leftJoin('shops', 'shop_second_hand_cars.shop_id', '=', 'shops.id')
            ->select("shop_second_hand_cars.*", 'shops.name as shop_name', 'shops.phone as shop_phone', 'shops.detail_address as shop_address')
            ->find($this->id);

        if (is_null($shopSecondHandCar)) {
            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $shopSecondHandCar,
        ];

        return response()->json($response);
    }
}
