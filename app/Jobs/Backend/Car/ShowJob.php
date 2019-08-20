<?php

namespace App\Jobs\Backend\Car;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Car;

class ShowJob
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
    public function __construct($id)
    {
        $this->car_id = $id;
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

        if (is_null($car->customize)) {
            $car->customize = [];
        }

        if (is_null($car->attr)) {
            $car->attr = [];
        } else {
            $car->attr = json_decode($car->attr, true);
        }

        if (is_null($car->carousel)) {
            $car->carousel = [];
        } else {
            $car->carousel = json_decode($car->carousel, true);

            foreach($car->carousel as $atom) {
                $full_carousel[] = url('/') . '/storage/' . $atom;
            }
        }

        $car->full_carousel = $full_carousel;

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $car
        ];

        return response()->json($response);
    }
}
