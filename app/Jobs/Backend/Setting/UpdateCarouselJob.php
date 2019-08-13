<?php

namespace App\Jobs\Backend\Setting;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class UpdateCarouselJob
{
    use Dispatchable, Queueable;

    private $uuid;
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
        $this->uuid = $params['uuid'];
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

            $code = trans('pheicloud.response.error.code');
            $msg = trans('pheicloud.response.error.msg');

        } else {

            $valArr = is_null(json_decode($carousels->value, true)) ? [] : json_decode($carousels->value, true);
            $temp = [];

            foreach ($valArr as &$atom) {
                if ($atom['uuid'] != $this->uuid) {
                    $temp[] = $atom;
                }
            }

            $tempNew = [
                'path' => $this->carousel,
                'type' => $this->type,
                'link' => $this->link,
                'uuid' => date("YmdHis") . str_random(10),
            ];

            array_push($temp, $tempNew);

            $carousels->value = json_encode($temp);
            $carousels->save();
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
        ];

        return response()->json($response);
    }
}
