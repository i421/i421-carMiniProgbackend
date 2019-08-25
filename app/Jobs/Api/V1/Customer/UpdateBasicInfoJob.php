<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class UpdateBasicInfoJob
{
    use Dispatchable, Queueable;

    private $openid;
    private $nickname;
    private $gender;
    private $avatar;
    private $province;
    private $city;
    private $area;
    private $detail_address;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->openid = $params['openid'];
        $this->nickname = $params['nickname'];
        $this->gender = $params['gender'];
        $this->avatar = $params['avatar'];
        $this->province = $params['province'];
        $this->city = $params['city'];
        $this->area = $params['area'];
        $this->detail_address = $params['detail_address'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = TableModels\Customer::where("openid", $this->openid)->update([
            'nickname' => $this->nickname,
            'avatar' => $this->avatar,
            'gender' => $this->gender,
            'province' => $this->province,
            'city' => $this->city,
            'area' => $this->area,
            'detail_address' => $this->detail_address,
        ]);

        if ($customer) {
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
