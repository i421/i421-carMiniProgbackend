<?php

namespace App\Jobs\Api\V3\Package;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class IndexJob
{
    use Dispatchable, Queueable;

    private $per_page;
    private $page;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->page = isset($params['page']) ? $params['page'] : 0;
        $this->per_page = isset($params['per_page']) ? $params['per_page'] : 10;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $packages = TableModels\Package::offset($this->page * $this->per_page)->take($this->per_page)->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $packages,
        ];

        return response()->json($response);
    }
}
