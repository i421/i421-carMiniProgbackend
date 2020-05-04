<?php

namespace App\Http\Controllers\Backend\V4;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Backend\V4\MallAccessoryClassify as MallAccessoryClassifyJobs;
use App\Http\Requests\Backend\V4\MallAccessoryClassify as MallAccessoryClassifyRequests;

class MallAccessoryClassifyController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * 配件分类列表
     */
    public function index()
    {
        $response = $this->dispatch(new MallAccessoryClassifyJobs\IndexJob());
        return $response;
    }

    /**
     * 查看配件分类
     */
    public function show(int $id)
    {
        $response = $this->dispatch(new MallAccessoryClassifyJobs\ShowJob($id));
        return $response;
    }

    /**
     * 添加
     */
    public function store(MallAccessoryClassifyRequests\StoreRequest $request)
    {
        $params = $request->all();
        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $imgType = $img->extension();
            $imgName = date("YmdHis") . str_random(40) . ".$imgType";
            $imgUrl = $img->storeAs('mallAccessoryClassifyImg', $imgName, 'public');
            $params['img'] = $imgUrl;
        }
        $response = $this->dispatch(new MallAccessoryClassifyJobs\StoreJob($params));
        return $response;
    }

    /**
     * 更新
     */
    public function update(int $id, MallAccessoryClassifyRequests\UpdateRequest $request)
    {
        $params = $request->all();
        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $imgType = $img->extension();
            $imgName = date("YmdHis") . str_random(40) . ".$imgType";
            $imgUrl = $img->storeAs('mallAccessoryClassifyImg', $imgName, 'public');
            $params['img'] = $imgUrl;
        }
        $response = $this->dispatch(new MallAccessoryClassifyJobs\UpdateJob($id, $params));
        return $response;
    }

    /**
     * 删除配件分类
     */
    public function destroy(int $id)
    {
        $response = $this->dispatch(new MallAccessoryClassifyJobs\DestroyJob($id));
        return $response;
    }

    /**
     * 一级分类
     */
    public function primaryClassify()
    {
        $response = $this->dispatch(new MallAccessoryClassifyJobs\PrimaryClassifyJob());
        return $response;
    }

    /**
     * 二级分类
     */
    public function secondClassify()
    {
        $response = $this->dispatch(new MallAccessoryClassifyJobs\SecondClassifyJob());
        return $response;
    }

    /**
     * 查询
     */
    public function search()
    {
        $name = request()->input("name", '');
        $response = $this->dispatch(new MallAccessoryClassifyJobs\SearchJob($name));
        return $response;
    }
}
