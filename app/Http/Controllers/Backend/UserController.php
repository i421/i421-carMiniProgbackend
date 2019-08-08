<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\User as UserRequests;
use App\Jobs\Backend\User as UserJobs;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling restful user.
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('role:developer|admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->dispatch(new UserJobs\IndexJob());
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequests\StoreRequest $request)
    {
        $params = $request->all();
        $response = $this->dispatch(new UserJobs\StoreJob($params));
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $response = $this->dispatch(new UserJobs\ShowJob($id));
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequests\UpdateRequest $request, int $id)
    {
        $params = $request->all();
        $params['id'] = $id;
        $response = $this->dispatch(new UserJobs\UpdateJob($params));
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $response = $this->dispatch(new UserJobs\DestroyJob($id));
        return $response;
    }

    /**
     * Get User infomation
     *
     * @param  \Illuminate\Http\Request $request
     * @return json $response
     */
    public function info(Request $request)
    {
        $user = $request->user();
        $response = $this->dispatch(new UserJobs\InfoJob($user));
        return $response;
    }

    /**
     * Get User Permission
     *
     * @param  \Illuminate\Http\Request $request
     * @return json $response
     */
    public function permission(Request $request)
    {
        $user = $request->user();
        $response = $this->dispatch(new UserJobs\GetPermissionJob($user));
        return $response;
    }

    /**
     * update Password
     *
     * @param  \Illuminate\Http\Request $request
     * @return json $response
     */
    public function updatePassword(UserRequests\UpdatePasswordRequest $request)
    {
        $user = $request->user();
        $params = $request->all();
        $response = $this->dispatch(new UserJobs\UpdatePasswordJob($user, $params));
        return $response;
    }

    /**
     * update Avatar
     *
     * @param  \Illuminate\Http\Request $request
     * @return json $response
     */
    public function updateAvatar(UserRequests\UpdateAvatarRequest $request)
    {
        $user = $request->user();
        $avatar = $request->file('avatar');
        $imgType = $avatar->extension();
        $fileName = date("YmdHis") . str_random(40) . ".$imgType";
        $path = $avatar->storeAs('avatar', $fileName, 'public');
        $response = $this->dispatch(new UserJobs\UpdateAvatarJob($user, $path));
        return $response;
    }

    /**
     * Get user shops
     *
     * @return \Illuminate\Http\Response
     */
    public function shop(Request $request)
    {
        $user = $request->user();
        $response = $this->dispatch(new UserJobs\ShopJob($user));
        return $response;
    }
}
