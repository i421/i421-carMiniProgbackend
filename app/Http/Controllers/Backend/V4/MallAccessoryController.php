<?php

namespace App\Http\Controllers\Backend\V4;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Backend\V4\MallAccessory as MallAccessoryJobs;
use App\Http\Requests\Backend\V4\MallAccessory as MallAccessoryRequests;

class MallAccessoryController extends Controller
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
        $response = $this->dispatch(new MallAccessoryJobs\IndexJob());
        return $response;
    }

    /**
     * 查看配件分类
     */
    public function show(int $id)
    {
        $response = $this->dispatch(new MallAccessoryJobs\ShowJob($id));
        return $response;
    }

    /**
     * 添加
     */
    public function store(MallAccessoryRequests\StoreRequest $request)
    {
        $params = $request->all();
        $img = $request->file('img');
        $imgType = $img->extension();
        $imgName = date("YmdHis") . str_random(40) . ".$imgType";
        $imgUrl = $img->storeAs('mallAccessoryImg', $imgName, 'public');
        $params['img'] = $imgUrl;
        $response = $this->dispatch(new MallAccessoryJobs\StoreJob($params));
        return $response;
    }

    /**
     * 更新
     */
    public function update(int $id, MallAccessoryRequests\UpdateRequest $request)
    {
        $params = $request->all();

        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $imgType = $img->extension();
            $imgName = date("YmdHis") . str_random(40) . ".$imgType";
            $imgUrl = $img->storeAs('mallAccessoryImg', $imgName, 'public');
            $params['img'] = $imgUrl;
        }

        $response = $this->dispatch(new MallAccessoryJobs\UpdateJob($id, $params));
        return $response;
    }

    /**
     * 删除套餐
     */
    public function destroy(int $id)
    {
        $response = $this->dispatch(new MallAccessoryJobs\DestroyJob($id));
        return $response;
    }
}
