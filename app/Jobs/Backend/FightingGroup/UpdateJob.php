<?php

namespace App\Jobs\Backend\FightingGroup;

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
    private $car_id;
    private $type;
    private $group_price;
    private $total_num;
    private $start_time;
    private $end_time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->id = $params['id'];
        $this->car_id = $params['car_id'];
        $this->type = $params['type'];
        $this->group_price = $params['group_price'];
        $this->total_num = isset($params['total_num']) ? $params['total_num'] : null;
        $this->start_time = $params['time_range'][0];
        $this->end_time = $params['time_range'][1];
        $this->status = isset($params['status']) ? $params['status'] : 1;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fightingGroup = TableModels\FightingGroup::findOrFail($this->id);

        $fightingGroup->car_id = $this->car_id;
        $fightingGroup->type = $this->type;
        $fightingGroup->group_price = $this->group_price;
        $fightingGroup->total_num = is_null($this->total_num) ? 0 : $this->total_num;
        $fightingGroup->start_time = $this->start_time;
        $fightingGroup->end_time = $this->end_time;
        $fightingGroup->status = $this->status;
        $res = $fightingGroup->save();

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
