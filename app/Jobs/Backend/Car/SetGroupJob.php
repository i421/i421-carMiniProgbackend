<?php

namespace App\Jobs\Backend\Car;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Car;

class SetGroupJob
{
    use Dispatchable, Queueable;

    /**
     * @var integer $id
     */
    private $car_id;
    private $group_type;
    private $group_price;
    private $total_num;
    private $start_time;
    private $end_time;
    private $off;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->car_id = $params['car_id'];
        $this->group_type = $params['group_type'];
        $this->group_price = $params['group_price'];
        $this->total_num = isset($params['total_num']) ? $params['total_num'] : null;
        $this->start_time = $params['time_range'][0];
        $this->end_time = $params['time_range'][1];
        $this->off = $params['off'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $car = Car::findOrFail($this->car_id);

        $car->group_price = $this->group_price;
        $car->total_num = is_null($this->total_num) ? 0 : $this->total_num;
        $car->start_time = $this->start_time;
        $car->end_time = $this->end_time;
        $car->group_type = $this->group_type;
        $car->off = $this->off;
        $car->type = 2;
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
