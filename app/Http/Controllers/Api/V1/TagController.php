<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V1\Tag as TagJobs;

class TagController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  void
     * @return \Illuminate\Http\Response
     */
    public function classify()
    {
        $response = $this->dispatch(new TagJobs\ClassifyJob());
        return $response;
    }
}
