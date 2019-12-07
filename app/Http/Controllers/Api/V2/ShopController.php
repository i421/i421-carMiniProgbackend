<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V2\Shop as ShopJobs;

class ShopController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * 经销商二手车
     */
    public function secondHandCar()
    {
        $response = $this->dispatch(new ShopJobs\SecondHandCarJob());
        return $response;
    }
}
