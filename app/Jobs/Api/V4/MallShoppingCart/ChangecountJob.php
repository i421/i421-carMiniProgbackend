<?php

namespace App\Jobs\Api\V4\MallShoppingCart;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class ChangecountJob
{
    use Dispatchable, Queueable;

    private $id;
    private $count;
    private $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->id = $params['id'];
        $this->count = $params['count'];
        $this->type = $params['type'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type == 1) {
            // increment
            $res = TableModels\MallShoppingCart::where('id', $this->id)->increment("count", $this->count);
        } else {
            $mallShoppingCart = TableModels\MallShoppingCart::where('id', $this->id)->first();

            if (is_null($mallShoppingCart)) {
                $response = [
                    'code' => trans('pheicloud.response.error.code'),
                    'msg' => trans('pheicloud.response.error.msg'),
                ];
                return response()->json($response);
            }

            if ($mallShoppingCart->count < $this->count) {
                $response = [
                    'code' => trans('pheicloud.response.error.code'),
                    'msg' => trans('pheicloud.response.error.msg'),
                ];
                return response()->json($response);
            }

            if ($mallShoppingCart->count = $this->count) {
                $res = TableModels\MallShoppingCart::where('id', $this->id)->delete();
                $response = [
                    'code' => trans('pheicloud.response.success.code'),
                    'msg' => trans('pheicloud.response.success.msg'),
                ];
                return response()->json($response);
            } else {
                $res = TableModels\MallShoppingCart::where('id', $this->id)->decrement("count", $this->count);
            }
        }

        if ($res) {
            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');
        } else {
            $code = trans('pheicloud.response.error.code');
            $msg = trans('pheicloud.response.error.msg');
        }

        $response = [
            'code' => $code,
            'msg' => $msg,
        ];
        return response()->json($response);
    }
}
