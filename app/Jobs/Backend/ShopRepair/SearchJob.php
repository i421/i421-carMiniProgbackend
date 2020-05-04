<?php

namespace App\Jobs\Backend\ShopRepair;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class SearchJob
{
    use Dispatchable, Queueable;

    private $phone;
    private $time;
    private $name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->name = isset($params['name']) ? $params['name'] : null;
        $this->time = isset($params['time']) ? $params['time'] : null;
        $this->phone = isset($params['phone']) ? $params['phone'] : null;
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

        if (!is_null($this->time) && !empty($this->time)) {
            $tempRes->where([
                ['shop_repairs.updated_at', '>=', $this->time[0]],
                ['shop_repairs.updated_at', '<=', $this->time[1]]
            ]);
        }

        $shopRepairs = $tempRes->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $shopRepairs,
        ];

        return response()->json($response);
    }
}
