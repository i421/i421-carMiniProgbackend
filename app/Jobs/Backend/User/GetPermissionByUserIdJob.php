<?php

namespace App\Jobs\Backend\User;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use App\Tables as TablesModels;

class GetPermissionByUserIdJob
{
    use Dispatchable, Queueable;

    /**
     * 认证用户
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TablesModels\User $user)
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
        $roleLists = $this->user->roles;

        if (empty($roleLists)) {

            $response = [
                'code' => trans('pheicloud.response.empty.code'),
                'msg' => trans('pheicloud.response.empty.msg'),
            ];

            return response()->json($response);
        }

        $permissionInfo = [];

        foreach ($roleLists as $role) {
            $permission = TablesModels\Role::find($role['id'])->perms->toArray();
            array_push($permissionInfo, $permission);
        }

        $permissionInfo = generateMultiTree($permission);

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $permissionInfo
        ];

        return response()->json($response);
    }
}
