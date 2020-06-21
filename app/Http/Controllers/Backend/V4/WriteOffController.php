<?php

namespace App\Http\Controllers\Backend\V4; 

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Backend\V4\WriteOff as WriteOffJobs;

class WriteOffController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * 是否代理人
     *
     * @return void
     */
    public function search()
    {
        $params = request()->all();
        $response = $this->dispatch(new WriteOffJobs\SearchJob($params));
        return $response;
    }
}
