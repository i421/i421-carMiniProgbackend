<?php

namespace App\Jobs\Backend\User;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TablesModels;

class GetPermissionJob
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
                'code' => trans('pheicloud.response.success.code'),
                'msg' => trans('pheicloud.response.success.msg'),
                'data' => [],
            ];

            return response()->json($response);
        }

        $permissionInfo = [];

        foreach ($roleLists as $role) {
            $permission = TablesModels\Role::find($role['id'])->perms->toArray();
            array_push($permissionInfo, $permission);
        }

        $permissionInfo = array_collapse($permissionInfo);

        $ids = [];
        $resPerm = [];

        foreach ($permissionInfo as $atom) {
            if (in_array($atom['id'], $ids)) {
                continue;
            } else {
                array_push($resPerm, $atom);
                array_push($ids, $atom['id']);
            }
        }

        $resPerm = sortMultidimArray($resPerm, 'id', 'asc');

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => generateTree($resPerm),
        ];

        return response()->json($response);
    }
}
