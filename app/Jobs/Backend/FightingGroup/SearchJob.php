<?php

namespace App\Jobs\Backend\FightingGroup;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class SearchJob
{
    use Dispatchable, Queueable;

    private $type;
    private $time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->name = isset($params['type']) ? $params['type'] : null;
        $this->time = isset($params['time']) ? $params['time'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = TableModels\FightingGroup::select(
            'id', 'type', 'car_id', 'created_at'
        );

        if (!is_null($this->type) && !empty($this->type)) {
            $tempRes->where('type', $this->type);
        }

        if (!is_null($this->time) && count($this->time) > 1) {
            $tempRes->where([
                ['created_at', '>=', $this->time[0] . ' 00:00:00'],
                ['created_at', '<=', $this->time[1] . ' 23:59:59']
            ]);
        }

        $fightingGroups = $tempRes->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $fightingGroups,
        ];

        return response()->json($response);
    }
}
