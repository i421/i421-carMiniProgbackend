<?php

namespace App\Jobs\Backend\Setting;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class ShowCarouselJob
{
    use Dispatchable, Queueable;

    private $uuid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $carousels = TableModels\Setting::where('key', 'carousel')->get()->toArray();

        if (count($carousels) < 1) {

            $response = [
                'code' => trans('pheicloud.response.success.code'),
                'msg' => trans('pheicloud.response.success.msg'),
                'data' => [],
            ];

        } else {

            $carousels = json_decode($carousels[0]['value'], true);

            $temp = [];

            foreach ($carousels as &$carousel) {
                if ($carousel['uuid'] == $this->uuid) {
                    $carousel['path'] = 'storage/' . $carousel['path']; 
                    $temp = $carousel;
                    break;
                }
            }

            $response = [
                'code' => trans('pheicloud.response.success.code'),
                'msg' => trans('pheicloud.response.success.msg'),
                'data' => $temp,
            ];

        }

        return response()->json($response);
    }
}
