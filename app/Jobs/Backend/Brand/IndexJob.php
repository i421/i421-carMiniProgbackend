<?php

namespace App\Jobs\Backend\Brand;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class IndexJob
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $brands = TableModels\Brand::all();

        $cars = TableModels\Car::select(DB::raw('count(*) as car_count'), 'brand_id')->groupBy('brand_id')->get();

        foreach ($brands as & $brand) {

            $brand['car_count'] = 0;

            foreach ($cars as $car) {
                if ($brand->id == $car->brand_id) {
                    $brand['car_count'] = $car->car_count;
                    break;
                }
            }

        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $brands,
        ];

        return response()->json($response);
    }
}
