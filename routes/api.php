<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::get('/test', function () {
        return 'test';
    });
});

Route::group(['prefix' => 'v1/backend', 'namespace' => 'Backend', 'middleware' => 'auth:api'], function () {

    //用户管理
    Route::group(['prefix' => 'user'], function () {
        Route::get('info', 'UserController@info');
        Route::get('permission', 'UserController@permission');
        Route::post('update/password', 'UserController@updatePassword');
        Route::get('/', 'UserController@index');
        Route::post('/', 'UserController@store');
        Route::get('{id}', 'UserController@show');
        Route::put('{id}', 'UserController@update');
        Route::delete('{id}', 'UserController@destroy');
    });

    //角色管理
    Route::group(['prefix' => 'role'], function () {
        Route::get('/', 'RoleController@index');
        Route::post('/', 'RoleController@store');
        Route::get('{id}', 'RoleController@show');
        Route::put('{id}', 'RoleController@update');
        Route::delete('{id}', 'RoleController@destroy');
    });

});

Route::group(['prefix' => 'v1/backend', 'namespace' => 'Backend'], function () {

    //认证模块
    Route::group(['prefix' => 'oauth'], function () {
        Route::post('token', 'AuthController@auth');
    });

});

