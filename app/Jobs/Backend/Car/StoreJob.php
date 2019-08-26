<?php

namespace App\Jobs\Backend\Car;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class StoreJob
{
    use Dispatchable, Queueable;

    private $name;
    private $brand_id;
    private $avatar;
    private $guide_price;
    private $final_price;
    private $car_price;
    private $attr;
    private $carousel;
    private $customize;
    private $height;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->name = $params['name'];
        $this->brand_id = $params['brand_id'];
        $this->avatar = $params['avatar'];
        $this->guide_price = $params['guide_price'];
        $this->final_price = $params['final_price'];
        $this->car_price = $params['car_price'];
        $this->attr = $params['attr'];
        $this->height = $params['height'];
        $this->carousel = isset($params['carousel']) ? $params['carousel'] : null;
        $this->customize = isset($params['customize']) ? $params['customize'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $car = TableModels\Car::where('name', $this->name)->first();
        
        if (empty($car)) {

            $res = TableModels\Car::create([
                'brand_id' => $this->brand_id,
                'name' => $this->name,
                'avatar' => $this->avatar,
                'height' => $this->height,
                'guide_price' => $this->guide_price,
                'car_price' => $this->car_price,
                'final_price' => $this->final_price,
                'info' => [
                    'carousel' => $this->carousel, 
                    'attr' => $this->attr, 
                    'customize' => $this->customize, 
                ],
            ]);

            if ($res) {

                $code = trans('pheicloud.response.success.code');
                $msg = trans('pheicloud.response.success.msg');

            } else {

                $code = trans('pheicloud.response.error.code');
                $msg = trans('pheicloud.response.error.msg');

            }

        } else {

            $code = trans('pheicloud.response.exist.code');
            $msg = trans('pheicloud.response.exist.msg');

        }

        $response = [
            'code' => $code,
            'msg' => $msg,
        ];

        return response()->json($response);
    }
}
