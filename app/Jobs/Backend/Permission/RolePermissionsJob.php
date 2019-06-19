<?php

namespace App\Jobs\Backend\Permission;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TablesModels;

class RolePermissionsJob
{
    use Dispatchable, Queueable;

    /**
     * 角色ID
     *
     * @var integer $id
     */
    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $permissions = TablesModels\Permission::all();
        $rolePermissions = TablesModels\Role::findOrFail($this->id)->perms()->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => [
                'permissions' => $permissions,
                'rolePermissions' => $rolePermissions,
            ],
        ];

        return response()->json($response);
    }
}
