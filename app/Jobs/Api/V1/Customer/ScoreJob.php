<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class ScoreJob
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
        $scores = TableModels\Score::join('customers', 'scores.customer_id', '=', 'customers.id')
            ->where('customers.uuid', $this->uuid)
            ->select('scores.*')
            ->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $scores,
        ];

        return response()->json($response);
    }
}
