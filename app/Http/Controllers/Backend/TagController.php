<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Backend\Tag as TagJobs;

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
