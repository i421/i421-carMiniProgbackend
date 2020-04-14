<?php

namespace App\Jobs\Backend\V4\MallAccessoryOrder;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class IndexJob
{
    use Dispatchable, Queueable;

    private $page;
    private $pagesize;
    private $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pagesize = null, $page = null, $status)
    {
        $this->pagesize = is_null($pagesize) ? 10 : $pagesize;
        $this->page = is_null($page) ? 1 : $page;
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->status == -1) {
            $count = TableModels\MallAccessoryOrder::count();
            $mallAccessoryOrders = TableModels\MallAccessoryOrder::take($this->pagesize)->offset(($this->page - 1) * $this->pagesize)->get();
        } else {
            $count = TableModels\MallAccessoryOrder::where('status', $this->status)->count();
            $mallAccessoryOrders = TableModels\MallAccessoryOrder::where('status', $this->status)->take($this->pagesize)->offset(($this->page - 1) * $this->pagesize)->get();
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallAccessoryOrders,
            'total' => $count,
        ];

        return response()->json($response);
    }
}
