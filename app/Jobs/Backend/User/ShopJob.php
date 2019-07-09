<?php

namespace App\Jobs\Backend\User;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class ShopJob
{
    use Dispatchable, Queueable;

    /**
     * @var TableModels\User $user
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TableModels\User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $shops = $this->user->shops;
	
        if (is_null($shops)) {

            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);

        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $shops
        ];

        return response()->json($response);
    }
}
