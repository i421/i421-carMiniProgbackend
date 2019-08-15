<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Image as ImageRequests;

class ImageController extends Controller
{
    /**
     * 保存上传图片
     *
     * @param  image $file
     * @return json $response
     */
    public function store(ImageRequests\StoreRequest $request)
    {
        if (!$request->file('file')->isValid()) {
            $code = trans('pheicloud.response.fileNotValid.code');
            $msg = trans('pheicloud.response.fileNotValid.msg');
            $fileUrl = '';
        } else {
            $file = $request->file('file');
            $fileType = $file->extension();
            $fileName = date("YmdHis") . str_random(40) . ".$fileType";
            $fileUrl = $file->storeAs('miniProgram', $fileName, 'public');
            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');
        }

        $response = [
            'code' => $code,
            'msg' => $msg,
            'data' => [
                'full_path' => url('/') . '/storage/' . $fileUrl,
                'path' => $fileUrl,
            ],
        ];

        return $response;
    }
}
