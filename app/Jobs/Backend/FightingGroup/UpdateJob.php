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
    private $off;
    private $group_recommend;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->id = $params['id'];
        $this->group_type = $params['group_type'];
        $this->group_price = $params['group_price'];
        $this->total_num = isset($params['total_num']) ? $params['total_num'] : null;
        $this->start_time = $params['time_range'][0];
        $this->end_time = $params['time_range'][1];
        $this->off = $params['off'];
        $this->group_recommend = $params['group_recommend'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $car = TableModels\Car::findOrFail($this->id);

        $car->group_type = $this->group_type;
        $car->group_price = $this->group_price;
        $car->total_num = is_null($this->total_num) ? 0 : $this->total_num;
        $car->start_time = $this->start_time;
        $car->end_time = $this->end_time;
        $car->off = $this->off;
        $car->group_recommend = $this->group_recommend;
        $res = $car->save();

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
