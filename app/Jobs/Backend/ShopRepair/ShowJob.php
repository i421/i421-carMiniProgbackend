<?php

namespace App\Jobs\Backend\ShopRepair;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class ShowJob
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
        $data = TableModels\ShopRepair::leftJoin('shops', 'shop_repairs.shop_id', '=', 'shops.id')
            ->select('shop_repairs.*', 'shops.name as shop_name')
            ->where('shop_repairs.id', '=', $this->id)
            ->first();

        if (is_null($data)) {
            $response = [
                'code' => trans('pheicloud.response.empty.code'),
                'msg' => trans('pheicloud.response.empty.msg'),
                'data' => [],
            ];

            return response()->json($response);
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $data,
        ];

        return response()->json($response);
    }
}
