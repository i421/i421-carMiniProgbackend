<?php

namespace App\Jobs\Backend\Setting;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class UpdateMoneyValueJob
{
    use Dispatchable, Queueable;

    private $value;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->value = $params['value'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $setting = TableModels\Setting::where('key', 'v4_money_ratio')->first();

        if (is_null($setting)) {

            $list = [
                'key' => 'v4_money_ratio',
                'value' => json_encode([
                    'agent_return_money' => $this->value[0],
                    'relation_return_money' => $this->value[1],
                    'partner_cannot_recycle_ratio' => $this->value[2]
                ])
            ];

            $res = TableModels\Setting::insert($list);

        } else {

            $res = TableModels\Setting::where('key', 'v4_money_ratio')->update([
                'value' => json_encode([
                    'agent_return_money' => $this->value[0],
                    'relation_return_money' => $this->value[1],
                    'partner_cannot_recycle_ratio' => $this->value[2]
                ])
            ]);
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
