<?php

namespace App\Jobs\Api\V1\ShopRepair;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class SearchJob
{
    use Dispatchable, Queueable;

    private $shop_id;
    private $name;
    private $phone;
    private $lat;
    private $lng;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->name = isset($params['name']) ? $params['name'] : null;
        $this->shop_id = isset($params['shop_id']) ? $params['shop_id'] : null;
        $this->phone = isset($params['phone']) ? $params['phone'] : null;
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
        $tempRes = TableModels\ShopRepair::select(
            'id', 'name', 'phone', 'img_url', 'address_id', 'detail_address', 'created_at'
        );
        $tempRes = TableModels\ShopRepair::leftJoin('shops', 'shop_repairs.shop_id', '=', 'shops.id')
            ->select('shop_repairs.*', 'shops.name as shop_name');

        if (!is_null($this->name) && !empty($this->name)) {
            $tempRes->where('shop_repairs.name', $this->name);
        }

        if (!is_null($this->phone) && !empty($this->phone)) {
            $tempRes->where('shop_repairs.phone', $this->phone);
        }

        if (!is_null($this->shop_id) && !empty($this->shop_id)) {
            $tempRes->where('shop_repairs.shop_id', $this->shop_id);
        }

        $repairs = $tempRes->get();

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
