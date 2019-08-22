<?php

namespace App\Jobs\Backend\Brand;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class StoreJob
{
    use Dispatchable, Queueable;

    private $name;
    private $head;
    private $logo;
    private $is_hot;
    private $rank;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->name = $params['name'];
        $this->logo = $params['logo'];
        $this->head = isset($params['head']) ? $params['head'] : '';
        $this->is_hot = isset($params['is_hot']) ? $params['is_hot'] : 0;
        $this->rank = isset($params['rank']) ? $params['rank'] : 1;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $flag = TableModels\Brand::where('name', $this->name)
            ->first();

        if (empty($flag)) {

            $brand = TableModels\Brand::create([
                'name' => $this->name,
                'head' => $this->head,
                'logo' => $this->logo,
                'is_hot' => $this->is_hot,
                'rank' => $this->rank,
            ]);

            if ($brand) {

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
