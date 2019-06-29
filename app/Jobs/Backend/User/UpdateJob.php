<?php

namespace App\Jobs\Backend\User;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class UpdateJob
{
    use Dispatchable, Queueable;

    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $email
     */
    private $email;

    /**
     * @var string $role_id
     */
    private $role_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->id = $params['id'];
        $this->name = isset($params['name']) ? $params['name'] : '';
        $this->nickname = isset($params['nickname']) ? $params['nickname'] : '';
        $this->email = $params['email'];
        $this->phone = $params['phone'];
        $this->role_id = $params['role_id'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = Tablemodels\User::where('email', '=', $this->email)
            ->orwhere('phone', '=', $this->phone)
            ->orwhere('name', '=', $this->name)
            ->first();

        if ($user->id == $this->id) {

            $user = TableModels\User::findOrFail($this->id);
            $user->name = $this->name;
            $user->nickname = $this->nickname;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->save();

            $user->roles()->sync($this->role_id);

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
