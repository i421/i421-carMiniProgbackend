<?php

namespace App\Jobs\Backend\Car;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class UpdateJob
{
    use Dispatchable, Queueable;

    private $id;
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
    private $model;
    private $staging24;
    private $staging36;
    private $staging48;
    private $down_payment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->id = $params['id'];
        $this->name = $params['name'];
        $this->brand_id = $params['brand_id'];
        $this->guide_price = $params['guide_price'];
        $this->final_price = $params['final_price'];
        $this->car_price = $params['car_price'];
        $this->height = $params['height'];
        $this->attr = $params['attr'];
        $this->down_payment = $params['down_payment'];
        $this->staging24 = isset($params['staging24']) ? $params['staging24']: 0;
        $this->staging36 = isset($params['staging36']) ? $params['staging36']: 0;
        $this->staging48 = isset($params['staging48']) ? $params['staging48']: 0;
        $this->customize = $params['customize'];
        $this->avatar = isset($params['avatar']) ? $params['avatar'] : null;
        $this->carousel = isset($params['carousel']) ? $params['carousel'] : null;
        $this->model = isset($params['model']) ? json_decode($params['model'], true) : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $car = TableModels\Car::select(
            'id', 'name', 'brand_id', 'guide_price', 'final_price', 'car_price', 'avatar', 'info->attr as attr',
            'info->carousel as carousel', 'info->customize as customize'
        )->findOrFail($this->id);

        if (!is_null($this->avatar)) {

            $originPath = storage_path('app/public') . '/' . $car->avatar;

            if (is_file($originPath)) {
                unlink($originPath);
            }
            $car->avatar = $this->avatar;
        }

        if (!is_null($this->carousel)) {

            $carousels = is_null($car->carousel) ? [] : $car->carousel;

            if (is_array($carousels)) {
                foreach ($carousels as $carousel) {

                    $originPath = storage_path('app/public') . '/' . $carousel;

                    if (is_file($originPath)) {
                        unlink($originPath);
                    }
                }
            } else {
                $originPath = storage_path('app/public') . '/' . $carousels;

                if (is_file($originPath)) {
                    unlink($originPath);
                }
            }

            $info['carousel'] = $this->carousel;

        } else {
            $info['carousel'] = json_decode($car->carousel, true);
        }

        $info['attr'] = $this->attr;
        $info['customize'] = $this->customize;
        
        $car->brand_id = $this->brand_id;
        $car->name = $this->name;
        $car->guide_price = $this->guide_price;
        $car->car_price = $this->car_price;
        $car->height = $this->height;
        $car->final_price = $this->final_price;
        if (!is_null($this->model)) {
            $car->model = $this->model;
        }
        $car->down_payment = $this->down_payment;
        $car->staging24 = $this->staging24;
        $car->staging36 = $this->staging36;
        $car->staging48 = $this->staging48;
        $car->info = $info;
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
