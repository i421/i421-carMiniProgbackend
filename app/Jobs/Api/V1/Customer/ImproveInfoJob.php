<?php

namespace App\Jobs\Api\V1\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class ImproveInfoJob
{
    use Dispatchable, Queueable;

    private $openid;
    private $name;
    private $id_card;
    private $bank_card;
    private $driver_license;
    private $id_card_front_path;
    private $id_card_back_path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->openid = $params['openid'];
        $this->name = $params['name'];
        $this->id_card = $params['id_card'];
        $this->bank_card = $params['bank_card'];
        $this->driver_license = $params['driver_license'];
        $this->id_card_front_path = $params['id_card_front_path'];
        $this->id_card_back_path = $params['id_card_back_path'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = TableModels\Customer::where("openid", $this->openid)->first();

        if (!empty($customer)) {

            $infoArr = json_decode($customer->getOriginal('info'), true);
            $infoArr['name'] = $this->name;
            $infoArr['id_card'] = $this->id_card;
            $infoArr['id_card_front_path'] = $this->id_card_front_path;
            $infoArr['id_card_back_path'] = $this->id_card_back_path;
            $infoArr['driver_license'] = $this->driver_license;
            $infoArr['bank_card'] = $this->bank_card;
            $customer->info = $infoArr;
            $customer->save();

        } else {

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
