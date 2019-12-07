<?php

namespace App\Jobs\Backend\V2\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class StoreSecondHandCarJob
{
    use Dispatchable, Queueable;

    private $shop_id;
    private $name;
    private $type;
    private $desc;
    private $phone;
    private $lat;
    private $lng;
    private $address;
    private $img;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->name = $params['name'];
        $this->shop_id = $params['shop_id'];
        $this->type = $params['type'];
        $this->img = $params['img'];
        $this->desc = $params['desc'];
        $this->phone = $params['phone'];
        $this->lat = $params['lat'];
        $this->lng = $params['lng'];
        $this->address = $params['address'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $shopSecondHandCar = TableModels\ShopSecondHandCar::where('name', $this->name)->first();
        
        if (empty($shopSecondHandCar)) {

            $res = TableModels\ShopSecondHandCar::create([
                'shop_id' => $this->shop_id,
                'name' => $this->name,
                'img' => $this->img,
                'type' => $this->type,
                'phone' => $this->phone,
                'desc' => $this->desc,
                'lat' => $this->lat,
                'lng' => $this->lng,
                'address' => $this->address,
            ]);

            if ($res) {
                $code = trans('pheicloud.response.success.code');
                $msg = trans('pheicloud.response.success.msg');
            } else {
                $code = trans('pheicloud.response.error.code');
                $msg = trans('pheicloud.response.error.msg');
            }

        } else {
            $code = trans('pheicloud.response.exist.code');
            $msg = trans('pheicloud.response.exist.msg');
        }

        $response = [
            'code' => $code,
            'msg' => $msg,
        ];

        return response()->json($response);
    }
}
