<?php

namespace App\Jobs\Api\V1\Setting;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class CarouselListJob
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
        $carousels = TableModels\Setting::where('key', 'carousel')->get()->toArray();

        if (count($carousels) < 1) {

            $response = [
                'code' => trans('pheicloud.response.success.code'),
                'msg' => trans('pheicloud.response.success.msg'),
                'data' => $carousels,
            ];

        } else {

            $carousels = json_decode($carousels[0]['value'], true);

            foreach ($carousels as &$carousel) {
                if ($carousel['type'] == 1 || $carousel['type'] == 3) {
		            $carousel['full_link'] = url('/') . '/api/v1/car/' . $carousel['link'];
                } else {
		            $carousel['full_link'] = $carousel['link'];
                }
                $carousel['path'] = 'storage/' . $carousel['path'];
                $carousel['full_path'] = url('/') . '/' . $carousel['path'];
            }

            $response = [
                'code' => trans('pheicloud.response.success.code'),
                'msg' => trans('pheicloud.response.success.msg'),
                'data' => $carousels,
            ];

        }

        return response()->json($response);
    }
}
