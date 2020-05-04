<?php

namespace App\Jobs\Backend\V4\MallAccessory;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateJob
{
    use Dispatchable, Queueable;

    private $id;
    private $name;
    private $avatar;
    private $mall_accessory_classify_id;
    private $price;
    private $count;
    private $score_price;
    private $detail;
    private $carousel;
    private $imgs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $params)
    {
        $this->id = $id;
        $this->name = $params['name'];
        $this->mall_accessory_classify_id = $params['mall_accessory_classify_id'];
        $this->price = $params['price'];
        $this->score_price = $params['score_price'];
        $this->count = $params['count'];
        $this->detail = $params['detail'];
        $this->carousel = isset($params['carousel']) ? $params['carousel'] : null;
        $this->imgs = isset($params['imgs']) ? $params['imgs'] : null;
        $this->avatar = isset($params['avatar']) ? $params['avatar'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mall_accessory = TableModels\MallAccessory::where('id', $this->id)->first();

        if (!is_null($this->avatar)) {
            $mall_accessory->avatar = $this->avatar;
        }

        if (!is_null($this->carousel)) {
            $mall_accessory->carousel = $this->carousel;
        }

        if (!is_null($this->imgs)) {
            $mall_accessory->imgs = $this->imgs;
        }

        $mall_accessory->name = $this->name;
        $mall_accessory->price = $this->price;
        $mall_accessory->score_price = $this->score_price;
        $mall_accessory->mall_accessory_classify_id = $this->mall_accessory_classify_id;
        $mall_accessory->count = $this->count;
        $mall_accessory->detail = $this->detail;
        $res = $mall_accessory->save();

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
