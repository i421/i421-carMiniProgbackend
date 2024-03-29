<?php

namespace App\Jobs\Api\V3\Customer;

use App\Tables as TableModels;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class WriteOffJob
{
    use Dispatchable, Queueable;

    private $customer_id;
    private $package_id;
    private $merchant_id;
    private $time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->time = $params['time'];
        $this->customer_id = $params['customer_id'];
        $this->package_id = $params['package_id'];
        $this->merchant_id = $params['merchant_id'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info("[log] merchant_id:$this->merchant_id" . "====" . "package_id=$this->package_id" . "-=======-" . "customer_id=$this->customer_id");

        $merchant = TableModels\Customer::find($this->merchant_id);
        if ($merchant->is_seller != 1) {
            $response = [
                'code' => trans('pheicloud.response.noPriviledges.code'),
                'msg' => trans('pheicloud.response.noPriviledges.msg'),
            ];

            return response()->json($response);
        }

        $customer_package = DB::table("customer_package")->where([
            ['customer_id', '=', $this->customer_id],
            ['package_id', '=', $this->package_id],
        ])->where('left_count', '>', '0')
        ->first();

        if (is_null($customer_package)) {
            $response = [
                'code' => trans('pheicloud.response.outOfLeftCount.code'),
                'msg' => trans('pheicloud.response.outOfLeftCount.msg'),
            ];
            return response()->json($response);
        }

        if (time() - $this->time > 300) {
            $response = [
                'code' => trans('pheicloud.response.outOfTime.code'),
                'msg' => trans('pheicloud.response.outOfTime.msg'),
            ];

            return response()->json($response);
        }


        $diff = time() - strtotime($customer_package->updated_at);

        // 三个月核销一次
        if ($diff < 7770000) {
            $response = [
                'code' => trans('pheicloud.response.tooClose.code'),
                'msg' => trans('pheicloud.response.tooClose.msg'),
            ];

            return response()->json($response);
        }

        // 开始事务
        DB::beginTransaction();

        try {
            // 套餐次数减1
            DB::table("customer_package")->where('id', $customer_package->id)->decrement('left_count', 1);
            DB::table("customer_package")->where('id', $customer_package->id)->update([
                'updated_at' => date("Y-m-d H:i:s")
            ]);

            // 核销积分发放
            $package = TableModels\Package::where('id', $this->package_id)->first();
            TableModels\Customer::where('id', $this->merchant_id)->increment('score', $package->seller_score);

            // 商家添加积分奖励记录
            $consumer = TableModels\Customer::where('id', $this->customer_id)->first();

            TableModels\CustomerRecharge::create([
                'customer_id' => $this->merchant_id,
                'score' => $package->seller_score,
                'content' => $consumer->phone . '核销积分奖励',
            ]);

            // 核销记录持久化
            TableModels\WriteOff::create([
                'merchant_id' => $this->merchant_id,
                'customer_id' => $this->customer_id,
                'content' => "核销套餐" . $package->name . ", 奖励" . $package->seller_score,
            ]);

            \Log::info("[success] merchant_id:$this->merchant_id" . "====" . "package_id=$this->package_id");

            DB::commit();

        } catch (\Exception $e) {

            DB::rollback();

            $response = [
                'code' => trans('pheicloud.response.error.code'),
                'msg' => trans('pheicloud.response.error.msg'),
            ];

            return response()->json($response);
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
        ];

        return response()->json($response);
    }
}
