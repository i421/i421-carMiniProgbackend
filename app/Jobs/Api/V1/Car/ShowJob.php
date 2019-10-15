<?php

namespace App\Jobs\Api\V1\Car;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Car;
use App\Tables\Collection;
use App\Tables\Tag;
use DB;

class ShowJob
{
    use Dispatchable, Queueable;

    /**
     * @var integer $id
     */
    private $car_id;
    private $customer_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $customer_id)
    {
        $this->car_id = $id;
        $this->customer_id = $customer_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $car = Car::select(
            'id', 'name', 'brand_id', 'guide_price', 'final_price', 'car_price', 'avatar',
            'type', 'group_type', 'group_price', 'total_num', 'current_num',
            'info->attr as attr', 'info->carousel as carousel', 'info->customize as customize',
            'down_payment', 'staging24', 'staging36', 'staging48', 'model', 'off',
            DB::raw('DATE_FORMAT(start_time, "%Y-%m-%d") as start_date'),
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
        $temp = (array)json_decode(json_decode($car->attr, true));

        $tagMapping = Tag::pluck('name', 'id');

        $tempArr = [];
        foreach ($temp as $key => $value) {
            $tagName = isset($tagMapping[$value]) ? $tagMapping[$value] : '';
            $tempArr[] = [$key => $tagName];
        }
        $car->attr = $tempArr;
    	$car->carousel = json_decode($car->carousel, true);

    	foreach($car->carousel as $atom) {
	       $full_carousel[] = url('/') . '/' . $atom;
    	}

        $car->full_carousel = $full_carousel;

        if (is_null($this->customer_id)) {
            $flag = 0;
        } else {
            $collection = Collection::where([
                ['customer_id', '=', $this->customer_id],
                ['car_id', '=', $this->car_id],
            ])->get()->toArray();

            $flag = count($collection) < 1 ? 0 : 1;
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $car,
            'collection' => $flag,
        ];

        return response()->json($response);
    }
}
