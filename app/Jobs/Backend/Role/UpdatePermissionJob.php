<?php

namespace App\Jobs\Backend\Role;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class UpdatePermissionJob
{
    use Dispatchable, Queueable;

    /**
     * 角色ID
     *
     * @var integer
     */
    private $role_id;

    /**
     * 类别
     *
     * @var string
     */
    private $direction;

    /**
     * movekeys
     *
     * @var string
     */
    private $keys;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->role_id = $params['id'];
        $this->direction = $params['direction'];
        $this->keys = $params['keys'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->direction == 'right') {
            $response = $this->addPerms();
        } else {
            $response = $this->delPerms();
        }

        return response()->json($response);
    }

    /**
     * 添加权限
     */
    private function addPerms()
    {
        $role = TableModels\Role::find($this->role_id);
        $res = $role->perms()->attach($this->keys);

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
        ];

        return $response;
    }

    /**
     * 删除权限
     */
    private function delPerms()
    {
        $role = TableModels\Role::find($this->role_id);
        $res = $role->perms()->detach($this->keys);

        if (!empty($res)) {
            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');
        } else {
            $code = trans('pheicloud.response.error.code');
            $msg = trans('pheicloud.response.error.msg');
        }

        $response = [
            'code' => $code,
            'msg' => $msg,
        ];

        return $response;
    }
}
