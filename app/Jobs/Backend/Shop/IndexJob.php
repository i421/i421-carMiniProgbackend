<?php

namespace App\Jobs\Backend\Shop;

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
        //
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

            foreach ($orders as $order) {
                if ($shop->id == $order->shop_id) {
                    $shop['order_count'] = $order->order_count;
                    break;
                }
            }

            $shop['address'] = $shop->province['value'] . $shop->city['value'] . $shop->area['value'];
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $shops,
        ];

        return response()->json($response);
    }
}
