<?php

namespace App\Jobs\Api\V1\ShopRepair;

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
        $this->lat = isset($params['lat']) ? $params['lat'] : 0;
        $this->lng = isset($params['lng']) ? $params['lng'] : 0;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $repairs = TableModels\ShopRepair::leftJoin('shops', 'shop_repairs.shop_id', '=', 'shops.id')
            ->select('shop_repairs.*', 'shops.name as shop_name')
            ->get();

        foreach ($repairs as & $repair) {
            $repair['distance'] = getDistance($this->lat, $this->lng, $repair->lat, $repair->lng);
        }

        $repairs = sortMultidimArray($repairs->toArray(), 'distance', 'asc');

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $repairs,
        ];

        return response()->json($response);
    }
}
