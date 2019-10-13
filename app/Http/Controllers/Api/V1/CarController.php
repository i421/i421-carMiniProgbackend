<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Car as CarRequests;
use App\Jobs\Api\V1\Car as CarJobs;
use App\Tables as TableModels;

class CarController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Car Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling restful user.
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('role:developer|admin');
    }

    /**
     * 汽车列表
     *
     * @return void
     */
    public function index()
    {
        $pagesize = request()->input('pagesize', 10);
        $response = $this->dispatch(new CarJobs\IndexJob($pagesize));
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        // 统计查看次数
        $car = TableModels\CarView::where('car_id', $id)->first();
        if (is_null($car)) {
            TableModels\CarView::create(['car_id' => $id, 'count' => 1]);
        } else {
            $car->count += 1;
            $car->save();
        }

        $customer_id = request()->input('customer_id', null);
        $response = $this->dispatch(new CarJobs\ShowJob($id, $customer_id));
        return $response;
    }

    /**
     * 查询
     *
     * @return void
     */
    public function search(CarRequests\SearchRequest $request)
    {
        // 查询关键词统计
        $name = $request->input('name', null);
        if (!is_null($name)) {
            $keyword = TableModels\KeywordSearch::where('word', $name)->first();
            if (is_null($keyword)) {
                TableModels\KeywordSearch::create(['word' => $name, 'count' => 1]);
            } else {
                $keyword->count += 1;
                $keyword->save();
            }
        }

        $params = $request->all();
        $response = $this->dispatch(new CarJobs\SearchJob($params));
        return $response;
    }
}
