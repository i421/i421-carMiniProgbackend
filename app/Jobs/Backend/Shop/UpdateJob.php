<?php

namespace App\Jobs\Backend\Shop;

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
    private $province;
    private $city;
    private $area;
    private $detail_address;
    private $img_url;
    private $license_url;
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
        $this->province = isset($params['province']) ? $params['province'] : null;
        $this->city = isset($params['city']) ? $params['city'] : null;
        $this->area = isset($params['area']) ? $params['area'] : null;
        $this->lat = $params['lat'];
        $this->lng = $params['lng'];
        $this->detail_address = $params['detail_address'];
        $this->img_url = isset($params['img_url']) ? $params['img_url'] : null;
        $this->license_url = isset($params['license_url']) ? $params['license_url'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $shop = TableModels\Shop::findOrFail($this->id);

        if (!is_null($this->img_url)) {

            $originPath = storage_path('app/public') . '/' . $shop->img_url;

            if (is_file($originPath)) {
                unlink($originPath);
            }
            $shop->img_url = $this->img_url;

        }

        if (!is_null($this->license_url)) {

            $originPath = storage_path('app/public') . '/' . $shop->license_url;

            if (is_file($originPath)) {
                unlink($originPath);
            }
            $shop->license_url = $this->license_url;

        }

        $shop->name = $this->name;
        $shop->phone = $this->phone;
        $shop->lat = $this->lat;
        $shop->lng = $this->lng;
        $shop->detail_address = $this->detail_address;
        $shop->province = $this->province;
        $shop->city = $this->city;
        $shop->area = $this->area;
        $res = $shop->save();

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
