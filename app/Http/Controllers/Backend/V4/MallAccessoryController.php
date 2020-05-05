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

        $avatar = $request->file('avatar');
        $imgType = $avatar->extension();
        $avatarImgName = date("YmdHis") . str_random(40) . ".$imgType";
        $avatarUrl = $avatar->storeAs('mallAccessoryImg', $avatarImgName, 'public');
        $params['avatar'] = $avatarUrl;

        //轮播图
        $carousels = $request->file('carousel');
        $carouselPaths = [];
        foreach ($carousels as $carousel) {
            $imgType = $carousel->extension();
            $imgName = date("YmdHis") . str_random(40) . ".$imgType";
            $imgUrl = $carousel->storeAs('mallAccessoryImg', $imgName, 'public');
            array_push($carouselPaths, 'storage/' . $imgUrl);
        }
        $params['carousel'] = $carouselPaths;

        //Img
        $imgs = $request->file('imgs');
        $imgsPaths = [];
        foreach ($imgs as $img) {
            $imgType = $img->extension();
            $imgName = date("YmdHis") . str_random(40) . ".$imgType";
            $imgUrl = $img->storeAs('mallAccessoryImg', $imgName, 'public');
            array_push($imgsPaths, 'storage/' . $imgUrl);
        }
        $params['imgs'] = $imgsPaths;

        $response = $this->dispatch(new MallAccessoryJobs\StoreJob($params));
        return $response;
    }

    /**
     * 更新
     */
    public function update(int $id, MallAccessoryRequests\UpdateRequest $request)
    {
        $params = $request->all();

        if ($request->hasFile('avatar')) {
            //封面图
            $avatar = $request->file('avatar');
            $imgType = $avatar->extension();
            $avatarImgName = date("YmdHis") . str_random(40) . ".$imgType";
            $avatarUrl = $avatar->storeAs('mallAccessoryImg', $avatarImgName, 'public');
            $params['avatar'] = $avatarUrl;
        }

        if ($request->hasFile('imgs')) {
            $imgs = $request->file('imgs');
            $imgsPaths = [];
            foreach ($imgs as $img) {
                $imgType = $img->extension();
                $imgName = date("YmdHis") . str_random(40) . ".$imgType";
                $imgUrl = $img->storeAs('mallAccessoryImg', $imgName, 'public');
                array_push($imgsPaths, 'storage/' . $imgUrl);
            }
            $params['imgs'] = $imgsPaths;
        }

        if ($request->hasFile('carousel')) {
            $carousels = $request->file('carousel');
            $carouselPaths = [];
            foreach ($carousels as $carousel) {
                $imgType = $carousel->extension();
                $imgName = date("YmdHis") . str_random(40) . ".$imgType";
                $imgUrl = $carousel->storeAs('mallAccessoryImg', $imgName, 'public');
                array_push($carouselPaths, 'storage/' . $imgUrl);
            }
            $params['carousel'] = $carouselPaths;
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

    /**
     * 切换状态
     */
    public function toggle(int $id)
    {
        $status = request()->input('status');
        $response = $this->dispatch(new MallAccessoryJobs\ToggleJob($id, $status));
        return $response;
    }

    /**
     * 查询
     */
    public function search()
    {
        $params = request()->all();
        $response = $this->dispatch(new MallAccessoryJobs\SearchJob($params));
        return $response;
    }
}
