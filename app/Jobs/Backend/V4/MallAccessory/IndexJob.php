<?php

namespace App\Jobs\Backend\V4\MallAccessory;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

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
        $mallAccessories = TableModels\MallAccessory::leftJoin(
            'mall_accessory_classifies', 'mall_accessories.mall_accessory_classify_id', '=', 'mall_accessory_classifies.id'
            )->select('mall_accessories.*', 'mall_accessory_classifies.name as classify_name', 'mall_accessory_classifies.id as classify_id', 'mall_accessory_classifies.p_name', 'mall_accessory_classifies.p_id', 'mall_accessory_classifies.height')
            ->orderBy('height', 'desc')
            ->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallAccessories,
        ];

        return response()->json($response);
    }
}
