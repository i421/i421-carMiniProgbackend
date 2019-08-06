<?php

namespace App\Jobs\Backend\FightingGroup;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class StoreJob
{
    use Dispatchable, Queueable;

    private $car_id;
    private $type;
    private $group_price;
    private $total_num;
    private $start_time;
    private $end_time;
    private $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->car_id = $params['car_id'];
        $this->type = $params['type'];
        $this->group_price = $params['group_price'];
        $this->total_num = isset($params['total_num']) ? $params['total_num'] : null;
        $this->status = isset($params['status']) ? $params['status'] : 1;
        $this->start_time = $params['time_range'][0];
        $this->end_time = $params['time_range'][1];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fightingGroup = TableModels\FightingGroup::create([
            'car_id' => $this->car_id,
            'type' => $this->type,
            'group_price' => $this->group_price,
            'total_num' => is_null($this->total_num) ? 0 : $this->total_num,
            'current_num' => 0,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
        ]);

        if ($fightingGroup) {

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
