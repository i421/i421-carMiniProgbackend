<?php

namespace App\Jobs\Backend\V4\MallAccessory;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class SearchJob
{
    use Dispatchable, Queueable;

    private $name;
    private $mall_accessory_classify_id;
    private $min_price;
    private $max_price;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->name = $params['name'];
        $this->classify = $params['classify'];
        $this->min_price = $params['min_price'];
        $this->max_price = $params['max_price'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $temp = TableModels\MallAccessory::leftJoin(
            'mall_accessory_classifies', 'mall_accessories.mall_accessory_classify_id', '=', 'mall_accessory_classifies.id'
            )->select('mall_accessories.*', 'mall_accessory_classifies.name as classify_name', 'mall_accessory_classifies.id as classify_id', 'mall_accessory_classifies.p_name', 'mall_accessory_classifies.p_id', 'mall_accessory_classifies.height');

        if (!is_null($this->name)) {
            $temp->where("mall_accessories.name", 'like', "%$this->name%");
        }
        if (!is_null($this->classify)) {
            $temp->where("mall_accessory_classifies.name", 'like', "%$this->classify%");
            $temp->orWhere("mall_accessory_classifies.p_name", 'like', "%$this->classify%");
        }
        if (!is_null($this->min_price)) {
            $temp->where("mall_accessory_classifies.price", '>=', $this->min_price);
        }
        if (!is_null($this->max_price)) {
            $temp->where("mall_accessory_classifies.price", '<=', $this->max_price);
        }

        $mallAccessories = $temp->orderBy('height', 'desc')->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallAccessories,
        ];

        return response()->json($response);
    }
}
