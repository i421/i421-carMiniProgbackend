<?php

namespace App\Jobs\Api\V1\Car;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class SearchJob
{
    use Dispatchable, Queueable;

    private $name;
    private $brand_id;
    private $min_price;
    private $max_price;
    private $order_type;
    private $tag_id;
    private $pagesize;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->name = isset($params['name']) ? $params['name'] : null;
        $this->brand_id = isset($params['brand_id']) ? $params['brand_id'] : null;
        $this->tag_id = isset($params['tag_id']) ? $params['tag_id'] : [];
        $this->min_price = isset($params['min_price']) ? $params['min_price'] : 0;
        $this->max_price = isset($params['max_price']) ? $params['max_price'] : 99999999999;
        $this->order_column = isset($params['order_column']) ? $params['order_column'] : 'car_price';
        $this->order_type = isset($params['order_type']) ? $params['order_type'] : 'desc';
        $this->pagesize = isset($params['pagesize']) ? $params['pagesize'] : 10;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = TableModels\Car::leftJoin('brands', 'cars.brand_id', '=', 'brands.id')
            ->select('cars.*', 'brands.name as brand_name');

        if (!is_null($this->name)) {
            $tempRes->where('cars.name', 'like', "%$this->name%");
        }
        
        if (!is_null($this->brand_id)) {
            $tempRes->where('cars.brand_id', $this->brand_id);
        }

        $tempRes->where([
            ['cars.car_price', '>=', $this->min_price],
            ['cars.car_price', '<=', $this->max_price],
        ]);

        $cars = $tempRes->orderBy($this->order_column, $this->order_type)->paginate($this->pagesize);

        $temp = [];

        if (count($this->tag_id) >= 1) {

            foreach ($cars as $car) {
                $attr = json_decode($car['info']['attr'], true);
                list($keys, $values) = array_divide($attr);

                $res = array_intersect($values, $this->tag_id);

                if (count($res) >= 1) {
                    $temp[] = $car;
                }
            }

        } else {
            $temp = $cars;
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $temp,
        ];

        return response()->json($response);
    }
}
