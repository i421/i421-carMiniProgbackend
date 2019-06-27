<?php

namespace App\Jobs\Backend\User;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class UpdateAvatarJob
{
    use Dispatchable, Queueable;

    /**
     * @var string
     */
    private $path;

    /**
     * @var Object 
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TableModels\User $user, string $path)
    {
        $this->user = $user;
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = TableModels\User::findOrFail($this->user->id);

        if (empty($user)) {

            $response = [
                'code' => trans("pheicloud.response.error.code"),
                'msg' => trans('pheicloud.response.error.msg'),
            ];

            return response()->json($response);
        }

        $originPath = storage_path('app/public') . '/' . $user->avatar;

        if (is_file($originPath)) {
            unlink($originPath);
        }

        $user->avatar = $this->path;
        $user->save();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => '/storage/' . $this->path,
        ];

        return response()->json($response);
    }
}
