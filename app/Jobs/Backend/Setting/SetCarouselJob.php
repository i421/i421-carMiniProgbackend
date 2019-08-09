<?php

namespace App\Jobs\Backend\Setting;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class SetCarouselJob
{
    use Dispatchable, Queueable;

    private $carousel;
    private $type;
    private $link;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->carousel = $params['carousel'];
        $this->type = $params['type'];
        $this->link = $params['link'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $carousels = TableModels\Setting::where('key', 'carousel')->first();

        if (is_null($carousels)) {

            $val[] = [
                'path' => $this->carousel,
                'type' => $this->type,
                'link' => $this->link,
                'uuid' => date("YmdHis") . str_random(10),
            ];

            $res = TableModels\Setting::create([
                'key' => 'carousel',
                'value' => json_encode($val),
            ]);

            if ($res) {
                $code = trans('pheicloud.response.success.code');
                $msg = trans('pheicloud.response.success.msg');
            } else {
                $code = trans('pheicloud.response.error.code');
                $msg = trans('pheicloud.response.error.msg');
            }

        } else {

            $valArr = is_null(json_decode($carousels->value, true)) ? [] : json_decode($carousels->value, true);

            $temp = [
                'path' => $this->carousel,
                'type' => $this->type,
                'link' => $this->link,
                'uuid' => date("YmdHis") . str_random(10),
            ];

            array_push($valArr, $temp);

            $carousels->value = json_encode($valArr);
            $carousels->save();
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
        ];

        return response()->json($response);
    }
}
