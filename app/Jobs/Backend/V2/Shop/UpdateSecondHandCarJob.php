<?php

namespace App\Jobs\Backend\V2\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class UpdateSecondHandCarJob
{
    use Dispatchable, Queueable;

    private $id;
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
    public function __construct($params)
    {
        $this->id = $params['id'];
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
        $shopSecondHandCar = TableModels\ShopSecondHandCar::select(
            'id', 'name', 'shop_id', 'type', 'desc', 'address', 'lat', 'lng', 'img', 'phone'
        )->findOrFail($this->id);

        if (!is_null($this->img)) {
            $imgs = is_null($shopSecondHandCar->img) ? [] : $shopSecondHandCar->img;

            foreach ($imgs as $img) {
                $originPath = storage_path('app/public') . '/' . $img;
                if (is_file($originPath)) {
                    unlink($originPath);
                }
            }
        }
        
        $shopSecondHandCar->shop_id = $this->shop_id;
        $shopSecondHandCar->name = $this->name;
        $shopSecondHandCar->type = $this->type;
        $shopSecondHandCar->phone = $this->phone;
        $shopSecondHandCar->desc = $this->desc;
        $shopSecondHandCar->lat = $this->lat;
        $shopSecondHandCar->lng = $this->lng;
        $shopSecondHandCar->address = $this->address;
        if (!is_null($this->img)) {
            $shopSecondHandCar->img = $this->img;
        }
        $res = $shopSecondHandCar->save();

        if ($res) {
            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');
        } else {
            $code = trans('pheicloud.response.error.code');
            $msg = trans('pheicloud.response.error.msg');
        }

        $response = [
            'code' => $code,
            'msg' => $msg,
        ];

        return response()->json($response);
    }
}
