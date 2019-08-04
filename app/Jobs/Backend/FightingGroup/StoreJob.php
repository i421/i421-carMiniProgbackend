<?php

namespace App\Jobs\Backend\FightingGroup;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class StoreJob
{
    use Dispatchable, Queueable;

    private $car_id;
    private $type;
    private $group_price;
    private $total_num;
    private $start_time;
    private $end_time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //todo
    }
}
