<?php

namespace App\Jobs\Backend\User;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class StoreJob
{
    use Dispatchable, Queueable;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string $password
     */
    private $password;

    /**
     * @var array $role_id
     */
    private $role_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->email = $params['email'];
        $this->phone = $params['phone'];
        $this->password = $params['password'];
        $this->role_id = $params['role_id'];
        $this->name = isset($params['name']) ? $params['name'] : '';
        $this->nickname = isset($params['nickname']) ? $params['nickname'] : '';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = TableModels\User::where('email', '=', $this->email)
            ->orwhere('phone', '=', $this->phone)
            ->orwhere('name', '=', $this->name)
            ->first();

        if (is_null($user)) {

            $user_id = TableModels\User::insertGetId([
                'name' => $this->name,
                'nickname' => $this->nickname,
                'phone' => $this->phone,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);

            $user = TableModels\User::find($user_id);
            $user->roles()->attach($this->role_id);

            if ($user) {

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
