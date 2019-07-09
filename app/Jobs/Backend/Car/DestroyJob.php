<?php

namespace App\Jobs\Backend\Car;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables\Car;
use stdClass;

class DestroyJob
{
    use Dispatchable, Queueable;

    /**
     * @var integer $id
     */
    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $car = Car::find($this->id);

        if (empty($car)) {

            $code = trans('pheicloud.response.notExist.code');
            $msg = trans('pheicloud.response.notExist.msg');

        } else {

            $car->delete();

            $code = trans('pheicloud.response.success.code');
            $msg = trans('pheicloud.response.success.msg');

        }

        $response = [
            'code' => $code,
            'msg' => $msg,
            'data' => new stdClass(),
        ];

        return response()->json($response);
    }
}
