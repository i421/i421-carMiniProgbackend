<?php

namespace App\Jobs\Backend\User;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;
use Hash;

class UpdatePasswordJob
{
    use Dispatchable, Queueable;

    /**
     * @var array [pass, checkPass]
     */
    private $params;
    /**
     * @var Object 
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TableModels\User $user, array $params)
    {
        $this->user = $user;
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = TableModels\User::findOrFail($this->user->id);

		$flag = Hash::check($this->params['oldPass'], $user->password);	

		if (!$flag) {

			$response = [
				'code' => trans('pheicloud.response.passwordNotSameAsBefore.code'),
				'msg' => trans('pheicloud.response.passwordNotSameAsBefore.msg'),
			];

			return response()->json($response);
		}

		$user->password = Hash::make($this->params['pass']);
		$user->save();
		\Log::info("[update Password]: user_id " . $this->user->id . " update password to " . $this->params['pass']);

		$response = [
			'code' => trans('pheicloud.response.success.code'),
			'msg' => trans('pheicloud.response.success.msg'),
		];

		return response()->json($response);
    }
}
