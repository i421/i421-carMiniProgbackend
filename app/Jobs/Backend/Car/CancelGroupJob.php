<?php

namespace App\Jobs\Backend\Car;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Car;

class CancelGroupJob
{
    use Dispatchable, Queueable;

    /**
     * @var integer $id
     */
    private $car_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->car_id = $params['car_id'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $car = Car::select(
            'id', 'name', 'brand_id', 'guide_price', 'final_price', 'car_price', 'avatar', 'info->attr as attr',
            'info->carousel as carousel', 'info->customize as customize'
        )->find($this->car_id);

        if (is_null($car)) {

            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);

        }

        $car->type = 1;
        $car->group_type = 0;
        $car->group_price = 0;
        $car->total_num = 0;
        $car->start_time = null;
        $car->end_time = null;
        $res = $car->save();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $res
        ];

        return response()->json($response);
    }
}
