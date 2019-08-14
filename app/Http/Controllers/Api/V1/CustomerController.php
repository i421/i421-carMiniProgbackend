<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer as CustomerRequests;
use App\Jobs\Api\V1\Customer as CustomerJobs;

class CustomerController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * code2Session
     */
    public function code2Session(Request $request)
    {
        $code = $request->input('code');
        $response = $this->dispatch(new CustomerJobs\Code2SessionJob($code));
        return $response;
    }

    /**
     * 保存用户
     */
    public function store(CustomerRequests\StoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\StoreJob($params));
        return $response;
    }

    /**
     * 更新手机号
     */
    public function updatePhone(CustomerRequests\UpdatePhoneRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\UpdatePhoneJob($params));
        return $response;
    }

    /**
     * 完善姓名和idCard
     */
    public function updateNameAndIdcard(CustomerRequests\UpdateNameAndIdcardRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\UpdateNameAndIdcardJob($params));
        return $response;
    }

    /**
     * 上传身份证
     */
    public function uploadIdcard(CustomerRequests\UploadIdcardRequest $request)
    {
        $params = $request->all();

        $front = $request->file('id_card_front_path');
        $imgType = $front->extension();
        $frontFileName = date("YmdHis") . str_random(40) . ".$imgType";
        $frontPath = $front->storeAs('customer/idcard', $frontFileName, 'public');
        $params['id_card_front_path'] = $frontPath;

        $back = $request->file('id_card_back_path');
        $imgType = $back->extension();
        $backFileName = date("YmdHis") . str_random(40) . ".$imgType";
        $backPath = $back->storeAs('customer/idcard', $backFileName, 'public');
        $params['id_card_back_path'] = $backPath;

        $response = $this->dispatch(new CustomerJobs\UploadIdcardJob($params));
        return $response;
    }

    /**
     * 上传银行卡
     */
    public function uploadBankcard(CustomerRequests\UploadBankcardRequest $request)
    {
        $params = $request->all();
        $bank = $request->file('bank_card');
        $imgType = $bank->extension();
        $bankFileName = date("YmdHis") . str_random(40) . ".$imgType";
        $bankPath = $bank->storeAs('customer/bankcard', $bankFileName, 'public');
        $params['bank_card'] = $bankPath;

        $response = $this->dispatch(new CustomerJobs\UploadBankcardJob($params));
        return $response;
    }

    /**
     * 上传驾驶证
     */
    public function uploadDrivingLicense(CustomerRequests\UploadDrivingLicenseRequest $request)
    {
        $params = $request->all();
        $driverLicense = $request->file('driver_license');
        $imgType = $driverLicense->extension();
        $driverLicenseFileName = date("YmdHis") . str_random(40) . ".$imgType";
        $driverLicensePath = $driverLicense->storeAs('customer/driverLicense', $driverLicenseFileName, 'public');
        $params['driver_license'] = $driverLicensePath;

        $response = $this->dispatch(new CustomerJobs\UploadDrivingLicenseJob($params));
        return $response;
    }

    //用户订单
    public function order($uuid)
    {
        $response = $this->dispatch(new CustomerJobs\OrderJob($uuid));
        return $response;
    }

    //用户拼团
    public function fightingGroup($uuid)
    {
        $response = $this->dispatch(new CustomerJobs\FightingGroupJob($uuid));
        return $response;
    }

    //用户收藏
    public function collection($uuid)
    {
        $response = $this->dispatch(new CustomerJobs\CollectionJob($uuid));
        return $response;
    }

    //用户积分
    public function score($uuid)
    {
        $response = $this->dispatch(new CustomerJobs\ScoreJob($uuid));
        return $response;
    }
}
