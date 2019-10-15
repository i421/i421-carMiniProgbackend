<?php

namespace App\Jobs\Backend\ShopRepair;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class UpdateJob
{
    use Dispatchable, Queueable;

    /**
     * ID
     *
     * @var integer
     */
    private $id;
    private $name;
    private $phone;
    private $address;
    private $shop_id;
    private $img;
    private $lat;
    private $lng;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->id = $params['id'];
        $this->name = $params['name'];
        $this->phone = $params['phone'];
        $this->shop_id = $params['shop_id'];
        $this->lat = $params['lat'];
        $this->lng = $params['lng'];
        $this->address = $params['address'];
        $this->img = isset($params['img']) ? $params['img'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $shoprepair = TableModels\ShopRepair::findOrFail($this->id);

        if (!is_null($this->img)) {

            $originPath = storage_path('app/public') . '/' . $shoprepair->img;

            if (is_file($originPath)) {
                unlink($originPath);
            }
            $shoprepair->img = $this->img;

        }

        $shoprepair->name = $this->name;
        $shoprepair->phone = $this->phone;
        $shoprepair->shop_id = $this->shop_id;
        $shoprepair->lat = $this->lat;
        $shoprepair->lng = $this->lng;
        $shoprepair->address = $this->address;
        $res = $shoprepair->save();

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
