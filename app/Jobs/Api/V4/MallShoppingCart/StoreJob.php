<?php

namespace App\Jobs\Api\V4\MallShoppingCart;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class StoreJob
{
    use Dispatchable, Queueable;

    private $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mallShoppingCart = TableModels\MallShoppingCart::where([
            ['customer_id', '=', $this->params['customer_id']],
            ['mall_accessory_id', '=', $this->params['mall_accessory_id']]
        ])->first();

        if (!is_null($mallShoppingCart)) {

            $mallShoppingCart->count += $this->params['count'];
            $mallShoppingCart->save();
            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');

        } else {
            $res = TableModels\MallShoppingCart::insert($this->params);

            if ($res) {
                $code = trans('pheicloud.response.success.code');
                $msg = trans('pheicloud.response.success.msg');
            } else {
                $code = trans('pheicloud.response.error.code');
                $msg = trans('pheicloud.response.error.msg');
            }
        }

        $response = [
           'code' => $code,
            'msg' => $msg,
        ];

        return response()->json($response);
    }
}
