<?php

namespace App\Jobs\Backend\Role;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class GetPermissionJob
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
        $permissions = TableModels\Permission::all();
        $rolePermissions = TableModels\Role::findOrFail($this->id)->perms()->get();

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => [
                'permission' => $permissions,
                'rolePermission' => $rolePermissions,
            ],
        ];

        return response()->json($response);
    }
}
