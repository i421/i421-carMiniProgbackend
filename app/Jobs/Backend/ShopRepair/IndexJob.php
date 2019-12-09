<?php

namespace App\Jobs\Backend\ShopRepair;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class IndexJob
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
    public function handle(TableModels\User $user)
    {
        $shopIds = $this->user->shops->pluck('id');

        $data = TableModels\ShopRepair::leftJoin('shops', 'shop_repairs.shop_id', '=', 'shops.id')
            ->whereIn('shop_repairs.shop_id', $shopIds)
            ->select('shop_repairs.*', 'shops.name as shop_name')
            ->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $data,
        ];

        return response()->json($response);
    }
}
