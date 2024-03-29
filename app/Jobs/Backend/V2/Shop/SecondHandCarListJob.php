<?php

namespace App\Jobs\Backend\V2\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class SecondHandCarListJob
{
    use Dispatchable, Queueable;

    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TableModels\User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $shopIds = $this->user->shops->pluck('id');

        $shopSecondHandCars = TableModels\ShopSecondHandCar::leftJoin('shops', 'shop_second_hand_cars.shop_id', '=', 'shops.id')
            ->whereIn('shop_second_hand_cars.shop_id', $shopIds)
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
