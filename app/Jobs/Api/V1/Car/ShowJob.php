<?php

namespace App\Jobs\Api\V1\Car;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Car;
use DB;

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
            'id', 'name', 'brand_id', 'guide_price', 'final_price', 'car_price', 'avatar', 'type', 'group_type', 'group_price', 'total_num', 'current_num',
            'info->attr as attr', 'info->carousel as carousel', 'info->customize as customize', DB::raw('DATE_FORMAT(start_time, "%Y-%m-%d") as start_date'),
	    DB::raw('DATE_FORMAT(end_time, "%Y-%m-%d") as end_date')
        )->find($this->car_id);

        if (is_null($car)) {

            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);

        }

       	$car->customize = json_decode($car->customize, true);
       	$car->attr = json_decode($car->attr, true);
    	$car->carousel = json_decode($car->carousel, true);

    	foreach($car->carousel as $atom) {
	    $full_carousel[] = url('/') . '/' . $atom;
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
