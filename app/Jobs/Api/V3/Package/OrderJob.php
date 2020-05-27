<?php

namespace App\Jobs\Api\V3\Package;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class OrderJob
{
    use Dispatchable, Queueable;

    private $customer_id;
    private $per_page;
    private $page;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->customer_id = isset($params['customer_id']) ? $params['customer_id'] : -1;
        $this->page = isset($params['page']) ? $params['page'] : 1;
        $this->per_page = isset($params['per_page']) ? $params['per_page'] : 10;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $tempPackage = TableModels\PackageOrder::where('customer_id', '=', $this->customer_id);

        $count = $tempPackage->count();

        $packages = $tempPackage->orderBy('created_at', 'desc')->offset(($this->page - 1) * $this->per_page)
            ->take($this->per_page)
            ->get();

        foreach ($packages as &$package) {
            $package['full_img'] = url('/') . '/storage/' . $package['img'];
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => [
                'packages' => $packages,
                'total' => $count,
            ]
        ];

        return response()->json($response);
    }
}
