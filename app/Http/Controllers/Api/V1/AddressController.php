<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V1\Address as AddressJobs;

class AddressController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  void
     * @return \Illuminate\Http\Response
     */
    public function getProvinces()
    {
        $response = $this->dispatch(new AddressJobs\GetProvincesJob());
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getCities(int $id)
    {
        $response = $this->dispatch(new AddressJobs\GetCitiesJob($id));
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getTowns(int $id)
    {
        $response = $this->dispatch(new AddressJobs\GetTownsJob($id));
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getFullPath(int $id)
    {
        $response = $this->dispatch(new AddressJobs\GetFullPathJob($id));
        return $response;
    }
}
