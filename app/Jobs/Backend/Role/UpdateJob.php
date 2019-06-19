<?php

namespace App\Jobs\Backend\Role;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class UpdateJob
{
    use Dispatchable, Queueable;

    /**
     * ID
     *
     * @var integer
     */
    private $id;

    /**
     * 英文名称
     *
     * @var string $name
     */
    private $name;

    /**
     * 中文名称
     *
     * @var string $display_zh_name
     */
    private $display_zh_name;

    /**
     * 英文名称
     *
     * @var string $display_en_name
     */
    private $display_en_name;

    /**
     * 描述
     *
     * @var string $description
     */
    private $description;

    /**
     * 状态
     *
     * @var integer
     */
    private $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->id = $params['id'];
        $this->name = $params['name'];
        $this->display_en_name = $params['display_name'];
        $this->display_zh_name = $params['display_name'];
        $this->description = $params['description'];
        $this->status = isset($params['status']) ? $params['status'] : 1;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $role = TableModels\Role::findOrFail($this->id);
        $role->name = $this->name;
        $role->display_en_name = $this->display_en_name;
        $role->display_zh_name = $this->display_zh_name;
        $role->description = $this->description;
        $role->status = $this->status;
        $role->save();

        if ($role) {

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

        return response()->json($response);
    }
}
