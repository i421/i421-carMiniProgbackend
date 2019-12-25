<?php

namespace App\Http\Controllers\Api\V3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V3\Package as PackageJobs;

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
}
