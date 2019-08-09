<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Setting as SettingRequests;
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

    public function setCarousel(SettingRequests\SetCarouselRequest $request)
    {
        $params = $request->all();
        $carousel = $request->file('carousel');
        $imgType = $carousel->extension();
        $imgName = date("YmdHis") . str_random(40) . ".$imgType";
        $imgUrl = $carousel->storeAs('system/Carousel', $imgName, 'public');
        $params['carousel'] = $imgUrl;
        $response = $this->dispatch(new SettingJobs\SetCarouselJob($params));
        return $response;
    }

    public function destroycarousel(string $uuid)
    {
        $response = $this->dispatch(new SettingJobs\DestroyCarouselJob($uuid));
        return $response;
    }
}
