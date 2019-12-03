<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class OrderJob
{
    use Dispatchable, Queueable;

    private $openid;
    private $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $openid, $type)
    {
        $this->openid = $openid;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $where = [['customers.openid', '=', $this->openid]];

        if (!is_null($this->type)) {
            $where[] = ['cars.type', '=', $this->type];
        }

        $orders = TableModels\Order::leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoin('shops', 'orders.shop_id', '=', 'shops.id')
            ->leftJoin('cars', 'orders.car_id', '=', 'cars.id')
            ->where($where)
	    ->select(
                'orders.*', 'cars.type', 'cars.group_type', 'cars.name as car_name', 'cars.final_price as final_price',
		'cars.avatar as avatar', 'shops.name as shop_name', 'customers.phone as phone', 'cars.guide_price', 'cars.group_price'
            )->orderBy("orders.created_at", 'desc')
            ->get()
            ->toArray();

        foreach ($orders as &$order) {
            $order['avatar'] = 'storage/' . $order['avatar'];
            $order['full_avatar'] = url('/') . '/' . $order['avatar'];
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $orders,
        ];

        return response()->json($response);
    }
}
