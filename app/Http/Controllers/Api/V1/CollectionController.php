<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Collection as CollectionRequests;
use App\Jobs\Api\V1\Collection as CollectionJobs;

class CollectionController extends Controller
{
    public function store(CollectionRequests\StoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new CollectionJobs\StoreJob($params));
        return $response;
    }

    public function destroy(int $id)
    {
        $response = $this->dispatch(new CollectionJobs\DestroyJob($id));
        return $response;
    }
}
