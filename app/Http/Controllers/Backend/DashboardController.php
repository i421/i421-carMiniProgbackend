<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Backend\Dashboard as DashboardJobs;

class DashboardController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  void
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->dispatch(new DashboardJobs\IndexJob());
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  void
     * @return \Illuminate\Http\Response
     */
    public function collectionRank()
    {
        $response = $this->dispatch(new DashboardJobs\CollectionRankJob());
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  void
     * @return \Illuminate\Http\Response
     */
    public function viewRank()
    {
        $response = $this->dispatch(new DashboardJobs\ViewRankJob());
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  void
     * @return \Illuminate\Http\Response
     */
    public function keywordRank()
    {
        $response = $this->dispatch(new DashboardJobs\KeywordRankJob());
        return $response;
    }
}
