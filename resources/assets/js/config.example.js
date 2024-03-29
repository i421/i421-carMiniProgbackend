/*
|--------------------------------------------------------------------------
| Api list
|--------------------------------------------------------------------------
|
*/

const Api = {
    'oauthToken': 'api/v1/backend/oauth/token',

    'users': 'api/v1/backend/user',
    'storeUser': 'api/v1/backend/user',
    'showUser': 'api/v1/backend/user/',
    'updateUser': 'api/v1/backend/user/',
    'destroyUser': 'api/v1/backend/user/',
    'userInfo': 'api/v1/backend/user/info',
    'userShop': 'api/v1/backend/user/shop',
    'userPermission': 'api/v1/backend/user/permission',
    'updatePassword': 'api/v1/backend/user/update/password',
    'updateAvatar': 'api/v1/backend/user/update/avatar',

    'roles': 'api/v1/backend/role',
    'storeRole': 'api/v1/backend/role',
    'showRole': 'api/v1/backend/role/',
    'updateRole': 'api/v1/backend/role/',
    'destroyRole': 'api/v1/backend/role/',
    'rolePermission': 'api/v1/backend/role/permission/',
    'updateRolePermission': 'api/v1/backend/role/permission/',

    'cars': 'api/v1/backend/car',
    'recommendCar': 'api/v1/backend/car/recommend/',
    'storeCar': 'api/v1/backend/car',
    'showCar': 'api/v1/backend/car/',
    'updateCar': 'api/v1/backend/car/update/',
    'destroyCar': 'api/v1/backend/car/',
    'searchCar': 'api/v1/backend/car/search',
    'setGroup': "api/v1/backend/car/set/group",
    'cancelGroup': "api/v1/backend/car/cancel/group",

    'shops': 'api/v1/backend/shop',
    'storeShop': 'api/v1/backend/shop',
    'showShop': 'api/v1/backend/shop/',
    'updateShop': 'api/v1/backend/shop/update/',
    'destroyShop': 'api/v1/backend/shop/',
    'searchShop': 'api/v1/backend/shop/search',

    'shoprepairs': 'api/v1/backend/shoprepair',
    'storeShopRepair': 'api/v1/backend/shoprepair',
    'showShopRepair': 'api/v1/backend/shoprepair/',
    'updateShopRepair': 'api/v1/backend/shoprepair/update/',
    'destroyShopRepair': 'api/v1/backend/shoprepair/',
    'searchShopRepair': 'api/v1/backend/shoprepair/search',

    'brands': 'api/v1/backend/brand',
    'storeBrand': 'api/v1/backend/brand',
    'showBrand': 'api/v1/backend/brand/',
    'updateBrand': 'api/v1/backend/brand/update/',
    'destroyBrand': 'api/v1/backend/brand/',
    'searchBrand': 'api/v1/backend/brand/search',

    'messages': 'api/v1/backend/message',
    'storeMessage': 'api/v1/backend/message',
    'showMessage': 'api/v1/backend/message/',
    'updateMessage': 'api/v1/backend/message/',
    'destroyMessage': 'api/v1/backend/message/',
    'searchMessage': 'api/v1/backend/message/search',

    'fightingGroups': 'api/v1/backend/fighting/group',
    'showFightingGroup': 'api/v1/backend/fighting/group/',
    'updateFightingGroup': 'api/v1/backend/fighting/group/',
    'searchFightingGroup': 'api/v1/backend/fighting/group/search',

    'customers': 'api/v1/backend/customer',
    'showCustomer': 'api/v1/backend/customer/',
    'searchCustomer': 'api/v1/backend/customer/search',
    'banCustomer': 'api/v1/backend/customer/ban/',
    'cutomerCheckList': 'api/v1/backend/customer/checkList',
    'customerCheckDetail': 'api/v1/backend/customer/checkDetail/',
    'customerAuthStatus': 'api/v1/backend/customer/authStatus',
    'customerToggleIsSeller': 'api/v1/backend/customer/isSeller',
    'customerToggleIsAgent': 'api/v4/backend/customer/isAgent',
    'customerToggleIsPartner': 'api/v4/backend/customer/isPartner',

    'brokers': 'api/v2/backend/customer/broker-list',
    'showBroker': 'api/v2/backend/customer/',
    'searchBroker': 'api/v2/backend/customer/search-broker',
    'brokerCheckList': 'api/v2/backend/customer/check-broker-list',
    'brokerCheckDetail': 'api/v2/backend/customer/check-broker-detail/',
    'brokerTypeAuthStatus': 'api/v2/backend/customer/type-auth-status',

    'brokerAddScore': 'api/v2/backend/customer/broker-add-score',
    'brokerDeleteScore': 'api/v2/backend/customer/broker-delete-score/',
    'brokerRechargeScoreList': 'api/v2/backend/customer/broker-recharge-score-list',
    'brokerRecyclingScoreList': 'api/v2/backend/customer/broker-recycling-score-list',
    'brokerDeleteRecyclingScore': 'api/v2/backend/customer/broker-delete-recycling-score/',
    'toggleBrokerRecyclingStatus': 'api/v2/backend/customer/toggle-recycling-score-status/',

    'secondHandCarList': 'api/v2/backend/shop/second-hand-car-list',
    'storeSecondHandCar': 'api/v2/backend/shop/store-second-hand-car',
    'destroySecondHandCar': 'api/v2/backend/shop/destroy-second-hand-car/',
    'showSecondHandCar': 'api/v2/backend/shop/second-hand-car/',
    'updateSecondHandCar': 'api/v2/backend/shop/update-second-hand-car/',

    'settingShowScore': 'api/v1/backend/setting/score',
    'settingUpdateScore': 'api/v1/backend/setting/score/update',

    'settingShowMoney': 'api/v1/backend/setting/money',
    'settingUpdateMoney': 'api/v1/backend/setting/money/update',

    'settingSetCarousel': 'api/v1/backend/setting/carousel',
    'settingShowCarousel': 'api/v1/backend/setting/carousel/',
    'settingUpdateCarousel': 'api/v1/backend/setting/carousel/update/',
    'destroySettingCarousel': 'api/v1/backend/setting/carousel/',

    'dashboard': 'api/v1/backend/dashboard',
    'dashboardCollectionRank': 'api/v1/backend/dashboard/collection/rank',
    'dashboardViewRank': 'api/v1/backend/dashboard/view/rank',
    'dashboardKeywordRank': 'api/v1/backend/dashboard/keyword/rank',

    'classifyTag': 'api/v1/backend/tag/classify',

    'orders': 'api/v1/backend/order',
    'showOrder': 'api/v1/backend/order/',
    'searchOrder': 'api/v1/backend/order/search',
    'orderStatus': 'api/v1/backend/order/arrive/',
    'destroyOrder': 'api/v1/backend/order/',

    'packages': 'api/v3/backend/package',
    'storePackage': 'api/v3/backend/package,
    'destroyPackage': 'api/v3/backend/package/',
    'showPackage': 'api/v3/backend/package/',
    'updatePackage': 'api/v3/backend/package/update/',

    'forums': 'api/v3/backend/forum',
    'showForum': 'api/v3/backend/forum/',
    'searchForum': 'api/v3/backend/forum/search',
    'checkForum': 'api/v3/backend/forum/check/',
    'destroyForum': 'api/v3/backend/forum/delete/',
    'topForum': 'api/v3/backend/forum/top/',

    'banComment': 'api/v3/backend/comment/ban/',

    'mallaccessories': 'api/v4/backend/mallaccessory',
    'searchMallAccessory': 'api/v4/backend/mallaccessory/search',
    'storeMallAccessory': 'api/v4/backend/mallaccessory',
    'toggleMallaccessoryStatus': 'api/v4/backend/mallaccessory/toggle/',
    'destroyMallaccessory': 'api/v4/backend/mallaccessory/',
    'mallAccessory': 'api/v4/backend/mallaccessory/',
    'updateMallAccessory': 'api/v4/backend/mallaccessory/update/',

    'mallAccessoryClassifies': 'api/v4/backend/mallaccessoryclassify',
    'searchMallAccessoryClassify': 'api/v4/backend/mallaccessoryclassify/search',
    'storeMallAccessoryClassify': 'api/v4/backend/mallaccessoryclassify',
    'updateMallAccessoryClassify': 'api/v4/backend/mallaccessoryclassify/update/',
    'deleteMallaccessoryClassify': 'api/v4/backend/mallaccessoryclassify/',
    'showMallaccessoryClassify': 'api/v4/backend/mallaccessoryclassify/',
    'primaryMallAccessoryClassifies': 'api/v4/backend/mallaccessoryclassify/primary',
    'secondMallAccessoryClassifies': 'api/v4/backend/mallaccessoryclassify/second',

    'searchMallOrder': 'api/v4/backend/mallaccessoryorder/search',
    'toggleMallOrderStatus': 'api/v4/backend/mallaccessoryorder/toggle/',
    'updateMallOrderExpress': 'api/v4/backend/mallaccessoryorder/update/express',
    'showMallOrder': 'api/v4/backend/mallaccessoryorder/',

    'searchMallRecharge': 'api/v4/backend/mallrecharge/search',
    'searchWriteOff': 'api/v4/backend/writeoff/search',
    'searchCustomerPackage': 'api/v4/backend/customerpackage/search',
}

export default Api
