<?php

namespace App\Jobs\Api\V4\MallAccessory;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class SearchJob
{
    use Dispatchable, Queueable;

    private $page;
    private $pagesize;
    private $key;
    private $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->pagesize = isset($params['pagesize']) ? $params['pagesize'] : 10;
        $this->page = isset($params['page']) ? $params['page'] : 1;
        $this->key = isset($params['key']) ? $params['key'] : '';
        $this->order = isset($params['order']) ? $params['order'] : 'created_at';
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
        )->select("mall_accessories.*")
        ->where([
            ['status', '=', "1"],
            ['mall_accessories.name', 'like', "%$this->key%"]
        ])->orWhere([
            ['status', '=', "1"],
            ['mall_accessory_classifies.type', '=', 2],
            ['mall_accessory_classifies.name', 'like', "%$this->key%"]
        ]);

        $count = $temp->count();

        $mallAccessory = $temp->orderBy($this->order, 'desc')
            ->take($this->pagesize)
            ->offset(($this->page - 1) * $this->pagesize)
            ->get();

        if (is_null($mallAccessory)) {
            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallAccessory,
            'total' => $count,
        ];

        return response()->json($response);
    }
}
