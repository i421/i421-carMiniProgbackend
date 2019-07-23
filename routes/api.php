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

Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1'], function () {

    //客户管理
    Route::group(['prefix' => 'customer'], function () {
        Route::get('code2session', 'CustomerController@code2Session');
        Route::get('store', 'CustomerController@store');
        Route::get('update/phone', 'CustomerController@updatePhone');
    });

    //地址管理
    Route::group(['prefix' => 'address'], function () {
        Route::get('provinces', 'AddressController@getProvinces');
        Route::get('cities/{id}', 'AddressController@getCities');
        Route::get('towns/{id}', 'AddressController@getTowns');
        Route::get('fullpath/{id}', 'AddressController@getFullPath');
    });

    //标签管理
    Route::group(['prefix' => 'tag'], function () {
        Route::get('classify', 'TagController@classify');
    });

    //品牌管理
    Route::group(['prefix' => 'brand'], function () {
        Route::get('/', 'BrandController@index');
        Route::get('search/{key}', 'BrandController@search');
    });
});

Route::group(['prefix' => 'v1/backend', 'namespace' => 'Backend', 'middleware' => 'auth:api'], function () {

    //用户管理
    Route::group(['prefix' => 'user'], function () {
        Route::get('info', 'UserController@info');
        Route::get('shop', 'UserController@shop');
        Route::get('permission', 'UserController@permission');
        Route::post('update/password', 'UserController@updatePassword');
        Route::post('update/avatar', 'UserController@updateAvatar');
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
        Route::get('permission/{id}', 'RoleController@getPermission');
        Route::put('permission/{id}', 'RoleController@updatePermission');
    });

    //汽车管理
    Route::group(['prefix' => 'car'], function () {
        Route::get('/', 'CarController@index');
        Route::post('/', 'CarController@store');
        Route::get('{id}', 'CarController@show');
        Route::put('{id}', 'CarController@update');
        Route::delete('{id}', 'CarController@destroy');
    });

    //经销商管理(店铺管理)
    Route::group(['prefix' => 'shop'], function () {
        Route::get('/', 'ShopController@index');
        Route::post('/', 'ShopController@store');
        Route::get('{id}', 'ShopController@show');
        Route::put('{id}', 'ShopController@update');
        Route::delete('{id}', 'ShopController@destroy');
    });

    //标签管理
    Route::group(['prefix' => 'brand'], function () {
        Route::get('search', 'BrandController@search');
        Route::get('/', 'BrandController@index');
        Route::post('/', 'BrandController@store');
        Route::get('{id}', 'BrandController@show');
        Route::put('{id}', 'BrandController@update');
        Route::delete('{id}', 'BrandController@destroy');
    });

    //客户管理
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/', 'CustomerController@index');
        Route::post('search', 'CustomerController@search');
        Route::post('checkList', 'CustomerController@checkList');
        Route::get('checkDetail/{id}', 'CustomerController@checkDetail');
        Route::get('authStatus', 'CustomerController@authStatus');
        Route::get('isSeller', 'CustomerController@isSeller');
        Route::get('{id}', 'CustomerController@show');
    });

    //订单管理
    Route::group(['prefix' => 'order'], function () {
        Route::get('/', 'OrderController@index');
        Route::get('{id}', 'OrderController@show');
    });

    //微信认证
    Route::any('/wechat', 'WechatController@serve');
});

Route::group(['prefix' => 'v1/backend', 'namespace' => 'Backend'], function () {

    //认证模块
    Route::group(['prefix' => 'oauth'], function () {
        Route::post('token', 'AuthController@auth');
    });

});

