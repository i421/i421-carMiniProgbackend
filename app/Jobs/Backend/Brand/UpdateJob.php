<?php

namespace App\Jobs\Backend\Brand;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class UpdateJob
{
    use Dispatchable, Queueable;

    /**
     * ID
     *
     * @var integer
     */
    private $id;
    private $name;
    private $head;
    private $logo;
    private $is_hot;
    private $rank;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->id = $params['id'];
        $this->name = isset($params['name']) ? $params['name'] : null;
        $this->logo = isset($params['logo']) ? $params['logo'] : null;
        $this->head = isset($params['head']) ? $params['head'] : null;
        $this->is_hot = isset($params['is_hot']) ? $params['is_hot'] : null;
        $this->rank = isset($params['rank']) ? $params['rank'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $brand = TableModels\Brand::findOrFail($this->id);

        if (!is_null($this->logo)) {

            $originPath = storage_path('app/public') . '/' . $brand->logo;

            if (is_file($originPath)) {
                unlink($originPath);
            }
            $brand->logo = $this->logo;
        }

        if (!is_null($this->is_hot)) {
            $brand->is_hot = $this->is_hot;
        }

        if (!is_null($this->rank)) {
            $brand->rank = $this->rank;
        }

        $brand->name = $this->name;
        $brand->head = $this->head;
        $res = $brand->save();

        if ($res) {

            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');

        } else {

            $code = trans('pheicloud.response.error.code');
            $msg = trans('pheicloud.response.error.msg');

        }

        $response = [
            'code' => $code,
            'msg' => $msg,
        ];

        return response()->json($response);
    }
}
