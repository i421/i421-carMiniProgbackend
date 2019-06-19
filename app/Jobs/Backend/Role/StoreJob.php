<?php

namespace App\Jobs\Backend\Role;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class StoreJob
{
    use Dispatchable, Queueable;

    /**
     * 角色名称
     *
     * @var string $name
     */
    private $name;

    /**
     * 英文名称
     *
     * @var string $display_name
     */
    private $display_en_name;

    /**
     * 中文名称
     *
     * @var string $display_name
     */
    private $display_zh_name;

    /**
     * 描述
     *
     * @var string $description
     */
    private $description;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->name = $params['name'];
        $this->display_zh_name = $params['display_name'];
        $this->display_en_name = $params['display_name'];
        $this->description = isset($params['description']) ? $params['description'] : '';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $role = TableModels\Role::withTrashed()
            ->where('name', $this->name)
            ->first();

        if (empty($role)) {

            $role = TableModels\Role::create([
                'name' => $this->name,
                'display_en_name' => $this->display_en_name,
                'display_zh_name' => $this->display_zh_name,
                'description' => $this->description,
                'status' => 1,
            ]);

            if ($role) {

                $code = trans('pheicloud.response.success.code');
                $msg = trans('pheicloud.response.success.msg');

            } else {

                $code = trans('pheicloud.response.error.code');
                $msg = trans('pheicloud.response.error.msg');

            }

        } else {

            $code = trans('pheicloud.response.exist.code');
            $msg = trans('pheicloud.response.exist.msg');

        }

        $response = [
            'code' => $code,
            'msg' => $msg,
        ];

        return response()->json($response);
    }
}
