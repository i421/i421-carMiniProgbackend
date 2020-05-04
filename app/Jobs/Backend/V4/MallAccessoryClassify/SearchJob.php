<?php

namespace App\Jobs\Backend\V4\MallAccessoryClassify;

use App\Tables as TableModels;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class SearchJob
{
    use Dispatchable, Queueable;

    private $name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (is_null($this->name)) {
            $mallAccessoryClassifies = TableModels\MallAccessoryClassify::all();
        } else {
            $mallAccessoryClassifies = TableModels\MallAccessoryClassify::where('name', 'like', "%$this->name%")->get();
        }

        $mallAccessories = TableModels\MallAccessory::select('mall_accessory_classify_id', DB::raw("count(*) as count"))
            ->where('status', '=', 1)
            ->groupBy("mall_accessory_classify_id")
            ->get();


        foreach ($mallAccessoryClassifies as &$mallAccessoryClassify) {
            $mallAccessoryClassify->count = 0;
            foreach($mallAccessories as $mallAccessory) {
                if ($mallAccessory['mall_accessory_classify_id'] == $mallAccessoryClassify->id) {
                    $mallAccessoryClassify->count = $mallAccessory['count'];
                }
            }
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallAccessoryClassifies,
        ];

        return response()->json($response);
    }
}
