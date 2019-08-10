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
    'storeCar': 'api/v1/backend/car',
    'showCar': 'api/v1/backend/car/',
    'updateCar': 'api/v1/backend/car/update/',
    'destroyCar': 'api/v1/backend/car/',

    'shops': 'api/v1/backend/shop',
    'storeShop': 'api/v1/backend/shop',
    'showShop': 'api/v1/backend/shop/',
    'updateShop': 'api/v1/backend/shop/update/',
    'destroyShop': 'api/v1/backend/shop/',
    'searchShop': 'api/v1/backend/shop/search',

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
    'storeFightingGroup': 'api/v1/backend/fighting/group',
    'showFightingGroup': 'api/v1/backend/fighting/group/',
    'updateFightingGroup': 'api/v1/backend/fighting/group/',
    'destroyFightingGroup': 'api/v1/backend/fighting/group/',
    'searchFightingGroup': 'api/v1/backend/fighting/group/search',

    'customers': 'api/v1/backend/customer',
    'showCustomer': 'api/v1/backend/customer/',
    'searchCustomer': 'api/v1/backend/customer/search',
    'cutomerCheckList': 'api/v1/backend/customer/checkList',
    'customerCheckDetail': 'api/v1/backend/customer/checkDetail/',
    'customerAuthStatus': 'api/v1/backend/customer/authStatus',
    'customerToggleIsSeller': 'api/v1/backend/customer/isSeller',

    'settingSetCarousel': 'api/v1/backend/setting/carousel',
    'destroySettingCarousel': 'api/v1/backend/setting/carousel/',

    'dashboard': 'api/v1/backend/dashboard',

    'classifyTag': 'api/v1/backend/tag/classify',

    'orders': 'api/v1/backend/order',
    'showOrder': 'api/v1/backend/order/',
    'searchOrder': 'api/v1/backend/order/search',
}

export default Api
