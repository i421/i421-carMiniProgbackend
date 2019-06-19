<?php

namespace App\Jobs\Backend\User;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TablesModels;

class IndexJob
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return json $response
     */
    public function handle()
    {
        $users = TablesModels\User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'developer');
        })->get();

        foreach ($users as $user) {
            $user['roleList'] = $user->roles->pluck('display_en_name');
        }

        $roles = TablesModels\Role::where('name', '!=', 'developer')
            ->select('id', 'name', 'display_en_name', 'display_zh_name')
            ->get();


        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $users,
        ];

        return response()->json($response);
    }
}
