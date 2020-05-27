<?php

namespace App\Jobs\Api\V4\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use App\Tables\Customer;

class PackageAppcodeJob
{
    use Dispatchable, Queueable;

    private $id;
    private $package_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $id, array $params)
    {
        $this->id = $id;
        $this->package_id = isset($params['package_id']) ? $params['package_id'] : '';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$miniProgram = \EasyWeChat::miniProgram();

		$response = $miniProgram->app_code->getUnlimit("$this->id&$this->package_id", [
			'page' => 'pages/index/index',
		]);

		\Log::info($response);

		if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
			$filename = $response->saveAs(storage_path('app/public') . '/package_app_code', 'package_appcode' . date("YmdHis") . '.png');
		}

		$response = [
			'code' => trans('pheicloud.response.success.code'),
			'msg' => trans('pheicloud.response.success.msg'),
			'data' => url('/') . '/storage/package_app_code/' . $filename,
		];

		return response()->json($response);
    }
}
