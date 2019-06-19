<?php

namespace App\Jobs\Backend\Permission;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TablesModels;
use stdClass;

class UpdatePermissionsJob
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
    private $type;

    /**
     * movekeys
     *
     * @var string
     */
    private $moved_keys;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->role_id = $params['id'];
        $this->type = $params['type'];
        $this->moved_keys = explode(',', $params['movedKeys']);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type == 'add') {

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
        $role = TablesModels\Role::find($this->role_id);
        $res = $role->perms()->attach($this->moved_keys);

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => new stdClass,
        ];

        return $response;
    }

    /**
     * 删除权限
     */
    private function delPerms()
    {
        $role = TablesModels\Role::find($this->role_id);
        $res = $role->perms()->detach($this->moved_keys);

        if (empty($res)) {

            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');

        } else {

            $code = trans('pheicloud.response.error.code');
            $msg = trans('pheicloud.response.error.msg');

        }

        $response = [
            'code' => $code,
            'msg' => $msg,
            'data' => new stdClass,
        ];

        return $response;
    }
}
