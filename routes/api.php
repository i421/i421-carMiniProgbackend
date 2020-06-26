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
        Route::get('appcode/{id}', 'CustomerController@appcode');
        Route::post('store', 'CustomerController@store');
        Route::get('update/phone', 'CustomerController@updatePhone');
        Route::get('update/basicinfo', 'CustomerController@updateBasicInfo');
        Route::post('improve/info', 'CustomerController@improveInfo');
        Route::get('collection/{openid}', 'CustomerController@collection');
        Route::get('order/{openid}', 'CustomerController@order');
        Route::get('score/{openid}', 'CustomerController@score');
        Route::post('upload/idcard', 'CustomerController@uploadIdcard');
        Route::post('upload/bankcard', 'CustomerController@uploadBankcard');
        Route::post('upload/drivinglicense', 'CustomerController@uploadDrivingLicense');
        Route::post('upload/nameandidcard', 'CustomerController@updateNameAndIdcard');
        Route::get('message/{openid}', 'CustomerController@message');
        Route::get('recommender/{id}', 'CustomerController@recommenderList');
        Route::get('search/recommender/{id}', 'CustomerController@searchRecommender');
        Route::get('bind/recommender', 'CustomerController@bindRecommender');
        Route::get('/getinfobyid/{id}', 'CustomerController@getInfoById');
        Route::get('{openid}', 'CustomerController@getInfo');
    });

    //标签管理
    Route::group(['prefix' => 'tag'], function () {
        Route::get('classify', 'TagController@classify');
    });

    //收藏管理
    Route::group(['prefix' => 'collection'], function () {
        Route::post('/', 'CollectionController@store');
        Route::delete('{id}', 'CollectionController@destroy');
        Route::get('cancel', 'CollectionController@cancelCollection');
    });

    //品牌管理
    Route::group(['prefix' => 'brand'], function () {
        Route::get('/', 'BrandController@index');
        Route::get('search/{key}', 'BrandController@search');
        Route::get('hot', 'BrandController@hot');
        Route::get('car/{brand_id}', 'BrandController@car');
    });

    //轮播图管理
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/carousel', 'SettingController@carouselList');
        Route::get('/ad', 'SettingController@ad');
    });

    //经销商管理(店铺管理)
    Route::group(['prefix' => 'shop'], function () {
        Route::get('/', 'ShopController@index');
        Route::get('{id}', 'ShopController@show');
    });

    //维修点
    Route::group(['prefix' => 'shoprepair'], function () {
        Route::get('search', 'ShopRepairController@search');
        Route::get('/', 'ShopRepairController@index');
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
        Route::get('off', 'FightingGroupController@off');
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

        // 商城积分支付
        Route::post('score', 'PaymentController@score');
    });

    //消息管理
    Route::group(['prefix' => 'message'], function () {
        Route::get('/', 'MessageController@index');
        Route::get('{id}', 'MessageController@show');
    });

    //订单查询
    Route::group(['prefix' => 'order'], function () {
        Route::get('search', 'OrderController@search');
    });

    //订单消息管理
    Route::group(['prefix' => 'order/message'], function () {
        Route::get('search', 'OrderMessageController@search');
    });

    //地址管理(不用)
    Route::group(['prefix' => 'address'], function () {
        Route::get('provinces', 'AddressController@getProvinces');
        Route::get('cities/{id}', 'AddressController@getCities');
        Route::get('towns/{id}', 'AddressController@getTowns');
        Route::get('fullpath/{id}', 'AddressController@getFullPath');
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
        Route::post('recommend/{id}', 'CarController@recommendCar');
        Route::get('/', 'CarController@index');
        Route::post('/', 'CarController@store');
        Route::post('/set/group', 'CarController@setGroup');
        Route::post('/cancel/group', 'CarController@cancelGroup');
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

    //维修点
    Route::group(['prefix' => 'shoprepair'], function () {
        Route::get('search', 'ShopRepairController@search');
        Route::get('/', 'ShopRepairController@index');
        Route::get('{id}', 'ShopRepairController@show');
        Route::post('/update/{id}', 'ShopRepairController@update');
        Route::post('/', 'ShopRepairController@store');
        Route::delete('{id}', 'ShopRepairController@destroy');
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
        Route::get('/score', 'SettingController@getScore');
        Route::get('/score/store', 'SettingController@storeScoreValue');
        Route::get('/score/update', 'SettingController@updateScoreValue');
        Route::get('/money', 'SettingController@getMoney');
        Route::get('/money/update', 'SettingController@updateMoneyValue');
    });

    //订单管理
    Route::group(['prefix' => 'order'], function () {
        Route::get('/', 'OrderController@index');
        Route::get('search', 'OrderController@search');
        Route::post('arrive/{id}', 'OrderController@arrive');
        Route::get('{id}', 'OrderController@show');
        Route::delete('{id}', 'OrderController@destroy');
    });

    //首页
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/collection/rank', 'DashboardController@collectionRank');
        Route::get('/view/rank', 'DashboardController@viewRank');
        Route::get('/keyword/rank', 'DashboardController@keywordRank');
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

Route::group(['prefix' => 'v2', 'namespace' => 'Api\V2'], function () {

    // 经纪人更新信息
    Route::group(['prefix' => 'customer'], function () {
        Route::post('apply-broker/{openid}', 'CustomerController@applyBroker');
        Route::post('improve-broker-info', 'CustomerController@improveBrokerInfo');
        Route::post('improve-broker-info-with-wechat-payment-code', 'CustomerController@improveBrokerInfoWithWechatPaymentCode');
        Route::post('broker-sub-score', 'CustomerController@brokerSubScore');
        Route::get('broker-recycling-score-list/{openid}', 'CustomerController@brokerRecyclingScoreList');
        Route::get('broker-recharge-score-list/{openid}', 'CustomerController@brokerRechargeScoreList');
    });

    // 经销商二手车
    Route::group(['prefix' => 'shop'], function () {
        Route::get('second-hand-car', 'ShopController@secondHandCar');
    });

    //拼团管理
    Route::group(['prefix' => 'fighting/group'], function () {
        Route::get('off', 'FightingGroupController@off');
    });

});

Route::group(['prefix' => 'v3', 'namespace' => 'Api\V3'], function () {

    // 购买套餐
    Route::group(['prefix' => 'customer'], function () {
        Route::post('buy-package', 'CustomerController@buyPackage');
        Route::get('write-off', 'CustomerController@writeOff');
    });

    // 套餐列表
    Route::group(['prefix' => 'package'], function () {
        Route::get('/', 'PackageController@index');
        Route::get('/customer/{id}', 'PackageController@customer');
        Route::get('/order/{id}', 'PackageController@order');
        Route::get('/qrcode', 'PackageController@qrcode');
    });

    // 论坛列表
    Route::group(['prefix' => 'forum'], function () {
        Route::get('/', 'ForumController@index');
        Route::get('{id}', 'ForumController@show');
        Route::post('/', 'ForumController@store');
        Route::post('/delete/{id}', 'ForumController@destroy');
        Route::post('/like/{id}', 'ForumController@like');
        Route::post('/unlike/{id}', 'ForumController@unlike');
    });

    // 论坛评论列表
    Route::group(['prefix' => 'comment'], function () {
        Route::post('/', 'CommentController@store');
        Route::post('/delete/{id}', 'CommentController@delete');
    });

});

Route::group(['prefix' => 'v2/backend', 'namespace' => 'Backend\V2', 'middleware' => 'auth:api'], function () {

    Route::group(['prefix' => 'customer'], function () {
        Route::get('broker-list', 'CustomerController@brokerList');
        Route::post('check-broker-list', 'CustomerController@checkBrokerList');
        Route::post('search-broker', 'CustomerController@searchBroker');
        Route::get('type-auth-status', 'CustomerController@typeAuthStatus');
        Route::get('check-broker-detail/{id}', 'CustomerController@checkBrokerDetail');
        Route::post('broker-add-score', 'CustomerController@brokerAddScore');
        Route::delete('broker-delete-score/{id}', 'CustomerController@brokerDeleteScore');
        Route::post('broker-recharge-score-list', 'CustomerController@brokerRechargeScoreList');
        Route::post('broker-recycling-score-list', 'CustomerController@brokerRecyclingScoreList');
        Route::delete('broker-delete-recycling-score/{id}', 'CustomerController@brokerDeleteRecyclingScore');
        Route::post('toggle-recycling-score-status/{id}', 'CustomerController@toggleRecyclingScoreStatus');
        Route::get('{id}', 'CustomerController@show');
    });

    // 经销商二手车
    Route::group(['prefix' => 'shop'], function () {
        Route::get('second-hand-car-list', 'ShopController@secondHandCarList');
        Route::get('second-hand-car/{id}', 'ShopController@showSecondHandCar');
        Route::post('store-second-hand-car', 'ShopController@storeSecondHandCar');
        Route::delete('destroy-second-hand-car/{id}', 'ShopController@destroySecondHandCar');
        Route::post('update-second-hand-car/{id}', 'ShopController@updateSecondHandCar');
    });

});

Route::group(['prefix' => 'v3/backend', 'namespace' => 'Backend\V3', 'middleware' => 'auth:api'], function () {

    Route::group(['prefix' => 'package'], function () {
        Route::get('/', 'PackageController@index');
        Route::get('{id}', 'PackageController@show');
        Route::post('/', 'PackageController@store');
        Route::post('update/{id}', 'PackageController@update');
        Route::delete('{id}', 'PackageController@destroy');
    });

    Route::group(['prefix' => 'customer'], function () {
        Route::get('/', 'CustomerController@packages');
        Route::get('{id}', 'CustomerController@package');
    });

    // 论坛列表
    Route::group(['prefix' => 'forum'], function () {
        Route::get('/', 'ForumController@index');
        Route::get('{id}', 'ForumController@show');
        Route::post('/search', 'ForumController@search');
        Route::post('/delete/{id}', 'ForumController@destroy');
        Route::post('/check/{id}', 'ForumController@check');
        Route::post('/top/{id}', 'ForumController@top');
    });

    // 评论论坛列表
    Route::group(['prefix' => 'comment'], function () {
        Route::post('/ban/{id}', 'CommentController@ban');
    });

});

//Route::group(['prefix' => 'v4/backend', 'namespace' => 'Backend\V4', 'middleware' => 'auth:api'], function () {
Route::group(['prefix' => 'v4/backend', 'namespace' => 'Backend\V4'], function () {

    Route::group(['prefix' => 'mallaccessoryclassify'], function () {
        Route::get('/', 'MallAccessoryClassifyController@index');
        Route::get('primary', 'MallAccessoryClassifyController@primaryClassify');
        Route::get('second', 'MallAccessoryClassifyController@secondClassify');
        Route::post('search', 'MallAccessoryClassifyController@search');
        Route::get('{id}', 'MallAccessoryClassifyController@show');
        Route::post('/', 'MallAccessoryClassifyController@store');
        Route::post('update/{id}', 'MallAccessoryClassifyController@update');
        Route::delete('{id}', 'MallAccessoryClassifyController@destroy');
    });

    Route::group(['prefix' => 'mallaccessory'], function () {
        Route::get('/', 'MallAccessoryController@index');
        Route::get('{id}', 'MallAccessoryController@show');
        Route::post('search', 'MallAccessoryController@search');
        Route::post('/', 'MallAccessoryController@store');
        Route::post('update/{id}', 'MallAccessoryController@update');
        Route::delete('{id}', 'MallAccessoryController@destroy');
        Route::post('/toggle/{id}', 'MallAccessoryController@toggle');
    });

    Route::group(['prefix' => 'mallaccessoryorder'], function () {
        Route::get('/', 'MallAccessoryOrderController@index');
        Route::get('{id}', 'MallAccessoryOrderController@show');
        Route::post('/search', 'MallAccessoryOrderController@search');
        Route::post('/toggle/{id}', 'MallAccessoryOrderController@toggleStatus');
        Route::post('/update/express', 'MallAccessoryOrderController@updateExpress');
        Route::delete('{id}', 'MallAccessoryOrderController@destroy');
    });

    // 汽配商城充值列表
    Route::group(['prefix' => 'mallrecharge'], function () {
        Route::post('/search', 'MallRechargeController@search');
    });

    Route::group(['prefix' => 'customer'], function () {
        Route::get('isAgent', 'CustomerController@isAgent');
        Route::get('isPartner', 'CustomerController@isPartner');
    });

    Route::group(['prefix' => 'writeoff'], function () {
        Route::post('search', 'WriteOffController@search');
    });

    Route::group(['prefix' => 'customerpackage'], function () {
        Route::post('search', 'CustomerPackageController@search');
    });
    
    Route::group(['prefix' => 'customerrecharge'], function () {
        Route::post('search', 'CustomerRechargeController@search');
    });
});

Route::group(['prefix' => 'v4', 'namespace' => 'Api\V4'], function () {

    // 赠送套餐
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/packageappcode', 'CustomerController@packageAppcode');
        Route::get('/receivepackage', 'CustomerController@receivePackage');
    });

    // 汽配商城分类
    Route::group(['prefix' => 'mallaccessoryclassify'], function () {
        Route::get('/', 'MallAccessoryClassifyController@index');
        Route::get('primary', 'MallAccessoryClassifyController@primaryClassify');
        Route::get('primary/tree/{id}', 'MallAccessoryClassifyController@showPrimaryTree');
        Route::get('{id}', 'MallAccessoryClassifyController@show');
    });

    // 汽配商城分类明细
    Route::group(['prefix' => 'mallaccessory'], function () {
        Route::get('/', 'MallAccessoryController@index');
        Route::get('classify/{id}', 'MallAccessoryController@classify');
        Route::get('search', 'MallAccessoryController@search');
        Route::get('{id}', 'MallAccessoryController@show');
    });

    // 汽配商城购物车
    Route::group(['prefix' => 'mallshoppingcart'], function () {
        Route::get('/search', 'MallShoppingCartController@search');
        Route::post('/changecount', 'MallShoppingCartController@changecount');
        Route::post('/delete/{id}', 'MallShoppingCartController@destroy');
        Route::post('/', 'MallShoppingCartController@store');
    });

    // 汽配商城充值列表
    Route::group(['prefix' => 'mallrecharge'], function () {
        Route::get('/search', 'MallRechargeController@search');
    });

    // 汽配商城消费列表
    Route::group(['prefix' => 'mallrecycle'], function () {
        Route::get('/search', 'MallRecycleController@search');
    });

    // 商城收件地址
    Route::group(['prefix' => 'malladdress'], function () {
        Route::get('/search', 'MallAddressController@search');
        Route::get('/{id}', 'MallAddressController@show');
        Route::post('update/{id}', 'MallAddressController@update');
        Route::post('/delete/{id}', 'MallAddressController@destroy');
        Route::post('/', 'MallAddressController@store');
    });

    // 商城订单
    Route::group(['prefix' => 'mallorder'], function () {
        Route::get('/search', 'MallAccessoryOrderController@search');
        Route::get('/{id}', 'MallAccessoryOrderController@show');
        Route::post('/toggle/status', 'MallAccessoryOrderController@toggleStatus');
        Route::post('/update/express', 'MallAccessoryOrderController@updateExpress');
        Route::delete('{id}', 'MallAccessoryOrderController@destroy');
    });
});
