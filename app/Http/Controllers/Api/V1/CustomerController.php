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
     * appcode
     */
    public function appcode(int $id)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\AppcodeJob($id, $params));
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
     * 更新用户信息: 姓名手机号、身份证、银行卡
     */
    public function improveInfo(CustomerRequests\ImproveInfoRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\ImproveInfoJob($params));
        return $response;
    }

    /**
     * 获取用户信息: 姓名、身份证号、身份证、银行卡、驾驶证、审核状态
     */
    public function getInfo(string $openid)
    {
        $response = $this->dispatch(new CustomerJobs\GetInfoJob($openid));
        return $response;
    }
    
    /**
     * 更新用户信息: 昵称，性别，地址，头像,openid
     */
    public function updateBasicInfo(CustomerRequests\UpdateBasicInfoRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\UpdateBasicInfoJob($params));
        return $response;
    }

    /**
     * 获取消息(系统+个人)
     */
    public function message(string $openid)
    {
        $response = $this->dispatch(new CustomerJobs\GetMessageJob($openid));
        return $response;
    }

    /**
     * 绑定推荐人
     */
    public function bindRecommender(CustomerRequests\BindRecommenderRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\BindRecommenderJob($params));
        return $response;
    }

    /**
     * 推荐人列表
     */
    public function recommenderList(string $id)
    {
        $response = $this->dispatch(new CustomerJobs\RecommenderListJob($id));
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
        $response = $this->dispatch(new CustomerJobs\UploadIdcardJob($params));
        return $response;
    }

    /**
     * 上传银行卡
     */
    public function uploadBankcard(CustomerRequests\UploadBankcardRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\UploadBankcardJob($params));
        return $response;
    }

    /**
     * 上传驾驶证
     */
    public function uploadDrivingLicense(CustomerRequests\UploadDrivingLicenseRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CustomerJobs\UploadDrivingLicenseJob($params));
        return $response;
    }

    //用户订单
    public function order($openid)
    {
        $type = request()->input('type');
        $response = $this->dispatch(new CustomerJobs\OrderJob($openid, $type));
        return $response;
    }

    //用户收藏
    public function collection($openid)
    {
        $response = $this->dispatch(new CustomerJobs\CollectionJob($openid));
        return $response;
    }

    //用户积分
    public function score($openid)
    {
        $response = $this->dispatch(new CustomerJobs\ScoreJob($openid));
        return $response;
    }
}
