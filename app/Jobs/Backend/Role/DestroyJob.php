<?php

namespace App\Jobs\Backend\Role;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Role;
use stdClass;

class DestroyJob
{
    use Dispatchable, Queueable;

    /**
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
        $role = Role::where('name', '!=', 'admin')->find($this->id);

        if (empty($role)) {

            $code = trans('pheicloud.response.notExist.code');
            $msg = trans('pheicloud.response.notExist.msg');

        } else {

            $role->users()->detach();
            $role->forceDelete();

            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');

        }

        $response = [
            'code' => $code,
            'msg' => $msg,
            'data' => new stdClass(),
        ];

        return response()->json($response);
    }
}
