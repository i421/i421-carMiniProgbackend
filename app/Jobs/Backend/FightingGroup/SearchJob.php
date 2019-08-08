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
    private $car_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->type = isset($params['type']) ? $params['type'] : null;
        $this->time = isset($params['time']) ? $params['time'] : null;
        $this->car_name = isset($params['car_name']) ? $params['car_name'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tempRes = TableModels\FightingGroup::leftJoin('cars', 'fighting_groups.car_id', '=', 'cars.id')
            ->select('cars.name as car_name', 'fighting_groups.*');

        if (!is_null($this->type) && !empty($this->type)) {
            $tempRes->whereIn('fighting_groups.type', $this->type);
        }

        if (!is_null($this->car_name)) {
            $tempRes->where('cars.name', 'like', "%$this->car_name%");
        }

        if (!is_null($this->time) && count($this->time) > 1) {
            $tempRes->where([
                ['fighting_groups.created_at', '>=', $this->time[0] . ' 00:00:00'],
                ['fighting_groups.created_at', '<=', $this->time[1] . ' 23:59:59']
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
