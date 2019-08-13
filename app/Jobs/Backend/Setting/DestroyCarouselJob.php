<?php

namespace App\Jobs\Backend\Setting;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class DestroyCarouselJob
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
        $carousels = TableModels\Setting::where('key', 'carousel')->first();

        if (is_null($carousels)) {

            $code = trans('pheicloud.response.notExist.code');
            $msg = trans('pheicloud.response.notExist.msg');

        } else {

            $valArr = json_decode($carousels->value, true);
            $temp = [];

            foreach ($valArr as $atom) {
                if ($atom['uuid'] != $this->uuid) {
                    $temp[] = $atom;
                } else {
                    $originPath = storage_path('app/public') . '/' . $atom['path'];
                    unlink($originPath);
                }
            }

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
