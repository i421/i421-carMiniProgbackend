<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V2\FightingGroup as FightingGroupJobs;

class FightingGroupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('role:developer|admin');
    }

    //优惠拼团
    public function off()
    {
        $response = $this->dispatch(new FightingGroupJobs\OffJob());
        return $response;
    }
}
