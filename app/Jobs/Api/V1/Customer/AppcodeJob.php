<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use App\Tables\Customer;

class AppcodeJob
{
    use Dispatchable, Queueable;

    private $id;
    private $nickname;
    private $phone;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $id, array $params)
    {
        $this->id = $id;
        $this->nickname = isset($params['nickname']) ? $params['nickname'] : '';
        $this->phone = isset($params['phone']) ? $params['phone'] : '';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$miniProgram = \EasyWeChat::miniProgram();

		$response = $miniProgram->app_code->getUnlimit("$this->id&$this->phone", [
			'page' => 'pages/my_recommend/my_commend',
		]);

		\Log::info($response);

		if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
			$filename = $response->saveAs(storage_path('app/public') . '/app_code', 'appcode' . date("YmdHis") . '.png');
		}

		Customer::where('id', $this->id)->update([
			'qr_code' => 'app_code/' . $filename
		]);
		$response = [
			'code' => trans('pheicloud.response.success.code'),
			'msg' => trans('pheicloud.response.success.msg'),
			'data' => url('/') . '/storage/app_code/' . $filename,
		];

		return response()->json($response);
    }
}
