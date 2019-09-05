<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class GetMessageJob
{
    use Dispatchable, Queueable;

    private $openid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $openid)
    {
        $this->openid = $openid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = TableModels\Customer::where('openid', $this->openid)->first();
        $messages = TableModels\Message::where('start_time', '<=', date("Y-m-d H:i:s"))->orderBy('start_time', 'desc')->get()->toArray();

        if (is_null($customer)) {

            $response = [
                'code' => trans('pheicloud.response.empty.code'),
                'msg' => trans('pheicloud.response.empty.msg'),
                'data' => [],
            ];

            return response()->json($response);
        }

        if (count($messages) > 1) {


            foreach ($messages as &$atom) {
                $flag = isset($atom['title']) ? 1 : 0;

                if ($flag) {
                    $atom['type'] = 1;
                } else {
                    $atom['type'] = 2;
                }
            }

        } else {

            $orderMessages = TableModels\OrderMessage::where('customer_id', $customer->id)->orderBy('created_at')->get()->toArray();

            $data = array_merge($messages, $orderMessages);

            foreach ($data as &$atom) {
                $flag = isset($atom['title']) ? 1 : 0;

                if ($flag) {
                    $atom['type'] = 1;
                } else {
                    $atom['type'] = 2;
                }
            }

            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');
        }

        $response = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];

        return response()->json($response);
    }
}
