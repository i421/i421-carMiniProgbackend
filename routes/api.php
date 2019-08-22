<?php

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
        Route::post('upload/idcard', 'CustomerController@uploadIdcard');
        Route::post('upload/bankcard', 'CustomerController@uploadBankcard');
        Route::post('upload/drivinglicense', 'CustomerController@uploadDrivingLicense');
        Route::get('collection/{openid}', 'CustomerController@collection');
        Route::get('order/{openid}', 'CustomerController@order');
        Route::get('score/{openid}', 'CustomerController@score');
        Route::get('fighting/group/{openid}', 'CustomerController@fightingGroup');
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

    //轮播图管理
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/carousel', 'SettingController@carouselList');
    });

    //经销商管理(店铺管理)
    Route::group(['prefix' => 'shop'], function () {
        Route::get('/', 'ShopController@index');
        Route::get('{id}', 'ShopController@show');
    });

    //汽车管理
    Route::group(['prefix' => 'car'], function () {
        Route::get('search', 'CarController@search');
        Route::get('/', 'CarController@index');
        Route::get('{id}', 'CarController@show');
    });

    //拼团管理
    Route::group(['prefix' => 'fighting/group'], function () {
        Route::get('/', 'FightingGroupController@index');
        Route::get('search', 'FightingGroupController@search');
        Route::get('{id}', 'FightingGroupController@show');
    });

    //图片管理
    Route::group(['prefix' => 'image'], function () {
        Route::post('/', 'ImageController@store');
    });

    //支付查询
    Route::group(['prefix' => 'payment'], function () {
        //微信发送支付结果
        Route::post('notify', 'PaymentController@notify');
        // 请求微信统一下单接口
        Route::post('pre_order', 'PaymentController@pre_order');
        // 请求微信接口, 查看订单支付状态
        Route::get('paid', 'PaymentController@paid');
    });

    //地址管理(不用)
    Route::group(['prefix' => 'address'], function () {
        Route::get('provinces', 'AddressController@getProvinces');
        Route::get('cities/{id}', 'AddressController@getCities');
        Route::get('towns/{id}', 'AddressController@getTowns');
        Route::get('fullpath/{id}', 'AddressController@getFullPath');
    });

    //消息管理
    Route::group(['prefix' => 'message'], function () {
        Route::get('/', 'MessageController@index');
        Route::get('{id}', 'MessageController@show');
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
        Route::get('search', 'CarController@search');
        Route::get('/', 'CarController@index');
        Route::post('/', 'CarController@store');
        Route::get('{id}', 'CarController@show');
        Route::post('update/{id}', 'CarController@update');
        Route::delete('{id}', 'CarController@destroy');
    });

    //经销商管理(店铺管理)
    Route::group(['prefix' => 'shop'], function () {
        Route::get('search', 'ShopController@search');
        Route::get('/', 'ShopController@index');
        Route::post('/update/{id}', 'ShopController@update');
        Route::post('/', 'ShopController@store');
        Route::get('{id}', 'ShopController@show');
        Route::delete('{id}', 'ShopController@destroy');
    });

    //标签管理
    Route::group(['prefix' => 'tag'], function () {
        Route::get('classify', 'TagController@classify');
    });

    //品牌管理
    Route::group(['prefix' => 'brand'], function () {
        Route::get('search', 'BrandController@search');
        Route::post('/update/{id}', 'BrandController@update');
        Route::get('/', 'BrandController@index');
        Route::post('/', 'BrandController@store');
        Route::get('{id}', 'BrandController@show');
        Route::delete('{id}', 'BrandController@destroy');
    });

    //消息管理
    Route::group(['prefix' => 'message'], function () {
        Route::get('search', 'MessageController@search');
        Route::put('{id}', 'MessageController@update');
        Route::get('/', 'MessageController@index');
        Route::post('/', 'MessageController@store');
        Route::get('{id}', 'MessageController@show');
        Route::delete('{id}', 'MessageController@destroy');
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

    //拼团管理
    Route::group(['prefix' => 'fighting/group'], function () {
        Route::get('search', 'FightingGroupController@search');
        Route::get('/', 'FightingGroupController@index');
        Route::put('{id}', 'FightingGroupController@update');
        Route::get('/', 'FightingGroupController@index');
        Route::post('/', 'FightingGroupController@store');
        Route::get('{id}', 'FightingGroupController@show');
        Route::delete('{id}', 'FightingGroupController@destroy');
    });

    //轮播图管理
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/carousel', 'SettingController@carouselList');
        Route::post('/carousel', 'SettingController@storeCarousel');
        Route::get('/carousel/{uuid}', 'SettingController@showCarousel');
        Route::post('/carousel/update/{uuid}', 'SettingController@updateCarousel');
        Route::get('/', 'BrandController@index');
        Route::delete('/carousel/{uuid}', 'SettingController@destroyCarousel');
    });

    //订单管理
    Route::group(['prefix' => 'order'], function () {
        Route::get('/', 'OrderController@index');
        Route::get('search', 'OrderController@search');
        Route::get('{id}', 'OrderController@show');
    });

    //首页
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', 'DashboardController@index');
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

