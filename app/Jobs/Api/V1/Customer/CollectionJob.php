<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class CollectionJob
{
    use Dispatchable, Queueable;

    private $openid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $openid)
    {
        $this->openid = $openid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $collections = TableModels\Collection::join('customers', 'collections.customer_id', '=', 'customers.id')
            ->join('cars', 'collections.car_id', '=', 'cars.id')
            ->where('customers.openid', $this->openid)
            ->select('customers.*', 'cars.id as car_id', 'cars.avatar as car_avatar', 'cars.name as car_name')
            ->orderBy("collections.created_at", 'desc')
            ->get();

        foreach ($collections as &$collection) {
            $collection['full_car_avatar'] = url('/') . '/storage/' . $collection->car_avatar;
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $collections,
        ];

        return response()->json($response);
    }
}
