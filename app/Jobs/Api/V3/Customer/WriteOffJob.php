<?php

namespace App\Jobs\Api\V3\Customer;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class WriteOffJob
{
    use Dispatchable, Queueable;

    private $customer_id;
    private $package_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->customer_id = $params['customer_id'];
        $this->package_id = $params['package_id'];
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
