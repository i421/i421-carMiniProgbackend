<?php

namespace App\Jobs\Backend\FightingGroup;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use DB;

class SearchJob
{
    use Dispatchable, Queueable;

    private $group_type;
    private $time;
    private $name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->group_type = isset($params['group_type']) ? $params['group_type'] : null;
        $this->time = isset($params['time']) ? $params['time'] : null;
        $this->name = isset($params['car_name']) ? $params['car_name'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = TableModels\Car::where('type', 2);

        if (!is_null($this->group_type) && !empty($this->group_type)) {
            $tempRes->whereIn('group_type', $this->group_type);
        }

        if (!is_null($this->name)) {
            $tempRes->where('name', 'like', "%$this->name%");
        }

        if (!is_null($this->time) && count($this->time) > 1) {
            $tempRes->where([
                ['created_at', '>=', $this->time[0] . ' 00:00:00'],
                ['created_at', '<=', $this->time[1] . ' 23:59:59']
            ]);
        }

        $data = $tempRes->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $data,
        ];

        return response()->json($response);
    }
}
