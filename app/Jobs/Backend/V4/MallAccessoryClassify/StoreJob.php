<?php

namespace App\Jobs\Backend\V4\MallAccessoryClassify;

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
        if ($this->params['type'] == 0) {
            $this->params['type'] = 1;
            $this->params['p_id'] = 0;
            $this->params['p_name'] = '';
        } else {
            $mallAccessoryClassify = TableModels\MallAccessoryClassify::where('id',  $this->params['type'])->first();
            if(is_null($mallAccessoryClassify)) {
                $response = [
                    'code' => trans('pheicloud.response.notExist.code'),
                    'msg' => trans('pheicloud.response.notExist.msg'),
                ];
                return response()->json($response);
            }
            $this->params['p_name'] = $mallAccessoryClassify->name;
            $this->params['p_id'] = $this->params['type'];
            $this->params['type'] = 2;
        }

        $res = TableModels\MallAccessoryClassify::insert($this->params);

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
