<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{
    public function __construct()
    {
        //
    }

    public function serve()
    {
        \Log::info('request arrived');
    }
}
