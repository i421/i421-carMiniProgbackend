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

    public function storeScoreValue(SettingRequests\StoreScoreValueRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new SettingJobs\StoreScoreValueJob($params));
        return $response;
    }

    public function updateScoreValue(SettingRequests\UpdateScoreValueRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new SettingJobs\UpdateScoreValueJob($params));
        return $response;
    }

    public function getScore()
    {
        $response = $this->dispatch(new SettingJobs\GetScoreJob());
        return $response;
    }

    public function updateMoneyValue(SettingRequests\UpdateMoneyValueRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new SettingJobs\UpdateMoneyValueJob($params));
        return $response;
    }

    public function getMoney()
    {
        $response = $this->dispatch(new SettingJobs\GetMoneyJob());
        return $response;
    }

    public function carouselList()
    {
        $response = $this->dispatch(new SettingJobs\CarouselListJob());
        return $response;
    }

    public function storeCarousel(SettingRequests\StoreCarouselRequest $request)
    {
        $params = $request->all();
        $carousel = $request->file('carousel');

        $fileSize = (int)($carousel->getClientSize() / 1024);

        $res = checkFileSize($fileSize, 512);

        if (!$res['flag']) {
            return $res['data'];
        }

        $imgType = $carousel->extension();
        $imgName = date("YmdHis") . str_random(40) . ".$imgType";
        $imgUrl = $carousel->storeAs('system/Carousel', $imgName, 'public');
        $params['carousel'] = $imgUrl;
        $response = $this->dispatch(new SettingJobs\StoreCarouselJob($params));
        return $response;
    }

    public function updateCarousel(SettingRequests\UpdateCarouselRequest $request, $uuid)
    {
        $params = $request->all();
        if ($request->hasFile('carousel')) {
            $carousel = $request->file('carousel');

            $fileSize = (int)($carousel->getClientSize() / 1024);

            $res = checkFileSize($fileSize, 512);

            if (!$res['flag']) {
                return $res['data'];
            }

            $imgType = $carousel->extension();
            $imgName = date("YmdHis") . str_random(40) . ".$imgType";
            $imgUrl = $carousel->storeAs('system/Carousel', $imgName, 'public');
            $params['carousel'] = $imgUrl;
        } else {
            $params['carousel'] = substr($request->input('carousel'), 8);
        }
        $params['uuid'] = $uuid;
        $response = $this->dispatch(new SettingJobs\UpdateCarouselJob($params));
        return $response;
    }

    public function showCarousel(string $uuid)
    {
        $response = $this->dispatch(new SettingJobs\ShowCarouselJob($uuid));
        return $response;
    }

    public function destroycarousel(string $uuid)
    {
        $response = $this->dispatch(new SettingJobs\DestroyCarouselJob($uuid));
        return $response;
    }
}
