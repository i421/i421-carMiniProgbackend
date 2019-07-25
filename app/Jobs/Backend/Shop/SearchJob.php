<?php

namespace App\Jobs\Backend\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class SearchJob
{
    use Dispatchable, Queueable;

    private $name;
    private $phone;
    private $time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->name = isset($params['name']) ? $params['name'] : null;
        $this->phone = isset($params['phone']) ? $params['phone'] : null;
        $this->time = isset($params['time']) ? $params['time'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = TableModels\Shop::select(
            'id', 'name', 'phone', 'img_url', 'address_id', 'detail_address', 'created_at'
        );

        if (!is_null($this->name) && !empty($this->name)) {
            $tempRes->where('name', $this->name);
        }

        if (!is_null($this->phone) && !empty($this->phone)) {
            $tempRes->where('phone', $this->phone);
        }

        if (!is_null($this->time) && count($this->time) > 1) {
            $tempRes->where([
                ['created_at', '>=', $this->time[0] . ' 00:00:00'],
                ['created_at', '<=', $this->time[1] . ' 23:59:59']
            ]);
        }

        $shops = $tempRes->get();

        $orders = TableModels\Order::select(DB::raw('count(*) as order_count'), 'shop_id')->groupBy('shop_id')->get();

        foreach ($shops as & $shop) {

            $shop['order_count'] = 0;

            foreach ($orders as $order) {
                if ($shop->id == $order->shop_id) {
                    $shop['order_count'] = $order->order_count;
                    break;
                }
            }

            $shop['address'] = getFullByAddressId($shop->address_id) . $shop->detail_address;
        }
        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $shops,
        ];

        return response()->json($response);
    }
}
