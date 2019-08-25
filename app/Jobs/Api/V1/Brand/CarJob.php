<?php

namespace App\Jobs\Api\V1\Brand;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TablesModels;

class CarJob
{
    use Dispatchable, Queueable;

    private $brand_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($brand_id)
    {
        $this->brand_id = $brand_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = TablesModels\Car::where('brand_id', $this->brand_id)->orderBy("created_at", 'desc')->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $data,
        ];

        return response()->json($response);
    }
}
