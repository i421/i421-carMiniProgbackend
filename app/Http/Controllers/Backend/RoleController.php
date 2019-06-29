<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Role as RoleRequests;
use App\Jobs\Backend\Role as RoleJobs;

class RoleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Role Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling restful user.
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
     * 用户角色列表
     *
     * @return void
     */
    public function index()
    {
        $response = $this->dispatch(new RoleJobs\IndexJob());
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequests\StoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new RoleJobs\StoreJob($params));
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $response = $this->dispatch(new RoleJobs\ShowJob($id));
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequests\UpdateRequest $request, int $id)
    {
        $params = $request->all();
        $params['id'] = $id;
        $response = $this->dispatch(new RoleJobs\UpdateJob($params));
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $response = $this->dispatch(new RoleJobs\DestroyJob($id));
        return $response;
    }

    /**
     * 获取角色权限
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getPermission(int $id)
    {
        $response = $this->dispatch(new RoleJobs\GetPermissionJob($id));
        return $response;
    }

    /**
     * 更新角色权限
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updatePermission(RoleRequests\UpdatePermissionRequest $request, int $id)
    {
        $params = $request->all();
        $params['id'] = $id;
        $response = $this->dispatch(new RoleJobs\UpdatePermissionJob($params));
        return $response;
    }
}
