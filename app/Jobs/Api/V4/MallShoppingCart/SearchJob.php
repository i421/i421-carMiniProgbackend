<?php

namespace App\Jobs\Api\V4\MallShoppingCart;

use App\Tables as TableModels;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class SearchJob
{
    use Dispatchable, Queueable;

    private $page;
    private $pagesize;
    private $customer_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->pagesize = isset($params['pagesize']) ? $params['pagesize'] : 10;
        $this->page = isset($params['page']) ? $params['page'] : 1;
        $this->customer_id = isset($params['customer_id']) ? $params['customer_id'] : null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (is_null($this->customer_id)) {

            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);
        }

        $temp = TableModels\MallShoppingCart::leftJoin('customers', 'mall_shopping_carts.customer_id', '=', 'customers.id')
            ->leftJoin('mall_accessories', 'mall_shopping_carts.mall_accessory_id', '=', 'mall_accessories.id')
            ->select("mall_accessories.*", 'mall_shopping_carts.count')
            ->where('customer_id', '=', $this->customer_id);

        $count = $temp->count();

        $mallShoppingCart = $temp->take($this->pagesize)
            ->offset(($this->page - 1) * $this->pagesize)
            ->get();

        if (is_null($mallShoppingCart)) {
            $response = [
                'code' => trans('pheicloud.response.notExist.code'),
                'msg' => trans('pheicloud.response.notExist.msg'),
            ];

            return response()->json($response);
        }

		foreach ($mallShoppingCart as &$atom) {

			$imgs = json_decode($atom['imgs'], true);
			$carousels = json_decode($atom['carousel'], true);

			foreach ($imgs as $img) {
				$tempImg[] = url('/') . '/' . $img;
			}

			$atom['full_imgs'] = $tempImg;

			foreach ($carousels as &$carousel) {
				$tempCarousel[] = url('/') . '/' . $img;
			}
			$atom['full_carousels'] = $tempCarousel;
		}

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $mallShoppingCart,
            'total' => $count,
        ];

        return response()->json($response);
    }
}
