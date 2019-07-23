<?php

namespace App\Jobs\Backend\Brand;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class SearchJob
{
    use Dispatchable, Queueable;

    private $name;
    private $time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->name = isset($params['name']) ? $params['name'] : null;
        $this->time = isset($params['time']) ? $params['time'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = TableModels\Brand::select(
            'id', 'name', 'logo', 'created_at'
        );

        if (!is_null($this->name) && !empty($this->name)) {
            $tempRes->where('name', $this->name);
        }

        if (!is_null($this->time) && count($this->time) > 1) {
            $tempRes->where([
                ['created_at', '>=', $this->time[0] . ' 00:00:00'],
                ['created_at', '<=', $this->time[1] . ' 23:59:59']
            ]);
        }

        $brands = $tempRes->get();

        $cars = TableModels\Car::select(DB::raw('count(*) as car_count'), 'brand_id')->groupBy('brand_id')->get();

        foreach ($brands as & $brand) {
            foreach ($cars as $car) {
                if ($brand->id == $car->brand_id) {
                    $brand['car_count'] = $car->car_count;
                    break;
                } else {
                    $brand['car_count'] = 0;
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
