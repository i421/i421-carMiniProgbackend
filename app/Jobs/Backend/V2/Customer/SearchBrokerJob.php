<?php

namespace App\Jobs\Backend\V2\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class SearchBrokerJob
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
        $tempRes = TableModels\Customer::select(
            'id', 'phone', 'nickname', 'openid', 'gender', 'recommend_count', 'status', 'type_auth as auth', 'created_at'
        );

        if (isset($this->params['phone']) && !empty($this->params['phone'])) {
            $tempRes->where('phone', 'like', '%' . $this->params['phone'] . '%');
        }

        if (isset($this->params['nickname']) && !empty($this->params['nickname'])) {
            $tempRes->where('nickname', 'like', '%' . $this->params['nickname'] . '%');
        }

        if (isset($this->params['time']) && count($this->params['time']) >= 1) {
            $tempRes->where([
                ['created_at', '>=', $this->params['time'][0] . ' 00:00:00'],
                ['created_at', '<=', $this->params['time'][1] . ' 23:59:59']
            ]);
        }

        if (isset($this->params['auth']) && count($this->params['auth']) >= 1) {
            $tempRes->whereIn('type_auth', $this->params['auth']);
        }

        $customers = $tempRes->isBroker()->get();

        $scores = TableModels\CustomerRecharge::select('customer_id', DB::raw("sum(score) as scores"))
            ->groupBy('customer_id')
            ->get();

        $recyclingScores = TableModels\CustomerRecycling::select('customer_id', DB::raw("sum(score) as scores"))
            ->where('status', '1')
            ->groupBy('customer_id')
            ->get();

        foreach ($customers as & $customer) {

            //初始化
            $customer->score_count = 0;
            $customer->recycling_score_count = 0;

            foreach ($scores as $score) {
                if ($customer->id == $score->customer_id) {
                    $customer->score_count = $score->scores;
                }
            }

            foreach ($recyclingScores as $atom) {
                if ($customer->id == $atom->customer_id) {
                    $customer->recycling_score_count = $atom->scores;
                }
            }
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $customers,
        ];

        return response()->json($response);
    }
}
