<?php

namespace App\Jobs\Api\V1\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class IndexJob
{
    use Dispatchable, Queueable;

    private $lat;
    private $lng;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->lat = isset($params['lat']) ? $params['lat'] : 1;
        $this->lng = isset($params['lng']) ? $params['lng'] : 1;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $shops = TableModels\Shop::all();

        $orders = TableModels\Order::select(DB::raw('count(*) as order_count'), 'shop_id')->groupBy('shop_id')->get();

        foreach ($shops as & $shop) {

            $shop['order_count'] = 0;
            $shop['distance'] = getDistance($this->lat, $this->lng, $shop->lat, $shop->lng);

            foreach ($orders as $order) {
                if ($shop->id == $order->shop_id) {
                    $shop['order_count'] = $order->order_count;
                    break;
                }
            }

            $shop['address'] = optional($shop->province)['value'] . optional($shop->city)['value'] . optional($shop->area)['value'];
        }

        $shops = sortMultidimArray($shops->toArray(), 'distance', 'asc');

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $shops,
        ];

        return response()->json($response);
    }
}
