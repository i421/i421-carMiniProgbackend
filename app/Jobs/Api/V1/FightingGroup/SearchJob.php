<?php

namespace App\Jobs\Api\V1\FightingGroup;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class SearchJob
{
    use Dispatchable, Queueable;

    private $group_type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->group_type = isset($params['group_type']) ? $params['group_type'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = TableModels\Car::where([
            ['type', '=', '2'],
            ['end_time', '>=', date("Y-m-d H:i:s")],
        ]);

        if (!is_null($this->group_type) && !empty($this->group_type)) {
            $tempRes->where('group_type', $this->group_type);
        }

        $data = $tempRes->get()->toArray();

        $tempRes = [];

        foreach ($data as &$group) {

            if ($group['group_type'] == 2) {
                for ($i = 1; $i <= $group['group_num']; $i++) {

                    $tempCountNum = $group['current_num'];

                    for ($i = 1; $i <= $group['group_num']; $i++) {

                        if ($i !== $group['group_num']) {
                            $group['current_num'] = $group['total_num'];
                            $tempRes[] = $group;
                            $group['current_num'] = $tempCountNum;
                        } else {
                            $group['current_num'] = $group['current_num'] % $group['total_num'];
                            $tempRes[] = $group;
                            $group['current_num'] = $tempCountNum;
                        }
                    }
                }
            } else {
                $tempRes[] = $group;
            }
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $tempRes,
        ];

        return response()->json($response);
    }
}
