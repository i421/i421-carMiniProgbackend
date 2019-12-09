<?php

namespace App\Http\Controllers\Backend\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\V2\Shop as ShopRequests;
use App\Jobs\Backend\V2\Shop as ShopJobs;

class ShopController extends Controller
{
    public function __construct()
    {
        //
    }

    public function secondHandCarList()
    {
        $response = $this->dispatch(new ShopJobs\SecondHandCarListJob());
        return $response;
    }

    public function showSecondHandCar(int $id)
    {
        $response = $this->dispatch(new ShopJobs\ShowSecondHandCarJob($id));
        return $response;
    }

    public function storeSecondHandCar(ShopRequests\StoreRequest $request)
    {
        $params = $request->all();

        //轮播图
        $imgs = $request->file('img');
        $imgsPaths = [];
        foreach ($imgs as $img) {
            $imgType = $img->extension();
            $imgName = date("YmdHis") . str_random(40) . ".$imgType";
            $imgUrl = $img->storeAs('secondHandCar', $imgName, 'public');
            array_push($imgsPaths, 'storage/' . $imgUrl);
        }
        $params['img'] = $imgsPaths;
        $response = $this->dispatch(new ShopJobs\StoreSecondHandCarJob($params));
        return $response;
    }

    public function destroySecondHandCar(int $id)
    {
        $response = $this->dispatch(new ShopJobs\DestroySecondHandCarJob($id));
        return $response;
    }

    public function updateSecondHandCar(ShopRequests\UpdateRequest $request, int $id)
    {
        $params = $request->all();
        $params['id'] = $id;

        //轮播图
        if ($request->hasFile('img')) {
            $imgs = $request->file('img');
            $imgsPaths = [];
            foreach ($imgs as $img) {
                $imgType = $img->extension();
                $imgName = date("YmdHis") . str_random(40) . ".$imgType";
                $imgUrl = $img->storeAs('secondHandCar', $imgName, 'public');
                array_push($imgsPaths, 'storage/' . $imgUrl);
            }
            $params['img'] = $imgsPaths;
        }

        $response = $this->dispatch(new ShopJobs\UpdateSecondHandCarJob($params));
        return $response;
    }
}
