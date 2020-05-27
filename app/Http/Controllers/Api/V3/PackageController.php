<?php

namespace App\Http\Controllers\Api\V3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V3\Package as PackageJobs;
use App\Http\Requests\Api\V3\Package as PackageRequests;

class PackageController extends Controller
{
    public function index()
    {
        $params = request()->all();
        $response = $this->dispatch(new PackageJobs\IndexJob($params));
        return $response;
    }

    public function customer(int $id)
    {
        $response = $this->dispatch(new PackageJobs\CustomerJob($id));
        return $response;
    }

    public function order(int $customer_id)
    {
        $params = request()->all();
        $params['customer_id'] = $customer_id;
        $response = $this->dispatch(new PackageJobs\OrderJob($params));
        return $response;
    }

    public function qrcode(PackageRequests\QrcodeRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new PackageJobs\QrcodeJob($params));
        return $response;
    }
}
