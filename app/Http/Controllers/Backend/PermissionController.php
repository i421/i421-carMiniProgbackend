<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Backend\Permission as PermissionJobs;

class PermissionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Permission Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling Rbac. 
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('role:developer|admin');
    }

    /**
     * 获取用户权限
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getListByRoleId(int $id)
    {
        $response = $this->dispatch(new PermissionJobs\RolePermissionsJob($id));
        return $response;
    }

    /**
     * 更新用户权限
     *
     * @return \Illuminate\Http\Response
     */
    public function updateByRoleId(int $id)
    {
        $params = request()->all();
        $params['id'] = $id;
        $response = $this->dispatch(new PermissionJobs\UpdatePermissionsJob($params));
        return $response;

    }
}
