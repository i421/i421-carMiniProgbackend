<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Backend\Setting as SettingJobs;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //todo
    }

    public function carouselList()
    {
        $response = $this->dispatch(new SettingJobs\CarouselListJob());
        return $response;
    }
}
