import Vue from 'vue'
import Router from 'vue-router'
import {encryptData, decryptData} from './../utils/encrypt'

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            redirect: '/dashboard'
        },
        {
            path: '/',
            beforeEnter: requireAuth,
            component: resolve => require(['./../components/layout/Home.vue'], resolve),
            children: [
                {
                    path: '/dashboard',
                    name: 'dashboard',
                    component: resolve => require(['../pages/dashboard/Index.vue'], resolve)
                }, {
                    path: '/customer',
                    component: resolve => require(['../pages/customer/Index.vue'], resolve)
                }, {
                    path: '/customer/check',
                    name: 'customerCheckList',
                    component: resolve => require(['../pages/customer/Check.vue'], resolve)
                }, {
                    path: '/customer/:id',
                    name: 'showCustomer',
                    component: resolve => require(['../pages/customer/Show.vue'], resolve)
                }, {
                    path: '/check/customer/:id',
                    name: 'showCustomerCheck',
                    component: resolve => require(['../pages/customer/CheckDetail.vue'], resolve)
                }, {
                    path: '/broker',
                    component: resolve => require(['../pages/broker/Index.vue'], resolve)
                }, {
                    path: '/broker/check',
                    name: 'brokerCheckList',
                    component: resolve => require(['../pages/broker/Check.vue'], resolve)
                }, {
                    path: '/broker/:id',
                    name: 'showBroker',
                    component: resolve => require(['../pages/broker/Show.vue'], resolve)
                }, {
                    path: '/check/broker/:id',
                    name: 'showBrokerCheck',
                    component: resolve => require(['../pages/broker/CheckDetail.vue'], resolve)
                }, {
                    path: '/broker/recharge/score/list',
                    name: 'brokerRechargeScoreList',
                    component: resolve => require(['../pages/broker/RechargeList.vue'], resolve)
                }, {
                    path: '/broker/recycling/score/list',
                    name: 'brokerRecyclingScoreList',
                    component: resolve => require(['../pages/broker/RecyclingList.vue'], resolve)
                }, {
                    path: '/second/hand/car/list',
                    name: 'secondHandCarList',
                    component: resolve => require(['../pages/secondHandCar/Index.vue'], resolve)
                }, {
                    path: '/second/hand/car/create',
                    name: 'createSecondHandCar',
                    component: resolve => require(['../pages/secondHandCar/Create.vue'], resolve)
                }, {
                    path: '/second/hand/car/:id',
                    name: 'showSecondHandCar',
                    component: resolve => require(['../pages/secondHandCar/Show.vue'], resolve)
                }, {
                    path: '/brand',
                    name: 'brand',
                    component: resolve => require(['../pages/brand/Index.vue'], resolve)
                }, {
                    path: '/brand/create',
                    name: 'createBrand',
                    component: resolve => require(['../pages/brand/Create.vue'], resolve)
                }, {
                    path: '/brand/:id',
                    name: 'showBrand',
                    component: resolve => require(['../pages/brand/Show.vue'], resolve)
                }, {
                    path: '/message',
                    name: 'message',
                    component: resolve => require(['../pages/message/Index.vue'], resolve)
                }, {
                    path: '/message/create',
                    name: 'createMessage',
                    component: resolve => require(['../pages/message/Create.vue'], resolve)
                }, {
                    path: '/message/:id',
                    name: 'showMessage',
                    component: resolve => require(['../pages/message/Show.vue'], resolve)
                }, {
                    path: '/shop',
                    name: 'shop',
                    component: resolve => require(['../pages/shop/Index.vue'], resolve)
                }, {
                    path: '/shop/create',
                    name: 'createShop',
                    component: resolve => require(['../pages/shop/Create.vue'], resolve)
                }, {
                    path: '/shop/:id',
                    name: 'showShop',
                    component: resolve => require(['../pages/shop/Show.vue'], resolve)
                }, {
                    path: '/shoprepair',
                    name: 'shoprepair',
                    component: resolve => require(['../pages/shoprepair/Index.vue'], resolve)
                }, {
                    path: '/shoprepair/create',
                    name: 'createShopRepair',
                    component: resolve => require(['../pages/shoprepair/Create.vue'], resolve)
                }, {
                    path: '/shoprepair/:id',
                    name: 'showShopRepair',
                    component: resolve => require(['../pages/shoprepair/Show.vue'], resolve)
                }, {
                    path: '/order',
                    name: 'order',
                    component: resolve => require(['../pages/order/Index.vue'], resolve)
                }, {
                    path: '/order/:id',
                    name: 'showOrder',
                    component: resolve => require(['../pages/order/Show.vue'], resolve)
                }, {
                    path: '/car',
                    name: 'car',
                    component: resolve => require(['../pages/car/Index.vue'], resolve)
                }, {
                    path: '/car/create',
                    name: 'createCar',
                    component: resolve => require(['../pages/car/Create.vue'], resolve)
                }, {
                    path: '/car/:id',
                    name: 'showCar',
                    component: resolve => require(['../pages/car/Show.vue'], resolve)
                }, {
                    path: '/fighting/group',
                    name: 'fightingGroup',
                    component: resolve => require(['../pages/fightingGroup/Index.vue'], resolve)
                }, {
                    path: '/fighting/group/create',
                    name: 'createFightingGroup',
                    component: resolve => require(['../pages/fightingGroup/Create.vue'], resolve)
                }, {
                    path: '/fighting/group/:id',
                    name: 'showFightingGroup',
                    component: resolve => require(['../pages/fightingGroup/Show.vue'], resolve)
                }, {
                    path: '/setting',
                    name: 'setting',
                    component: resolve => require(['../pages/setting/Index.vue'], resolve)
                }, {
                    path: '/setting/showcarousel/:id',
                    name: 'showSettingCarousel',
                    component: resolve => require(['../pages/setting/ShowSettingCarousel.vue'], resolve)
                }, {
                    path: '/setting/create',
                    name: 'createSettingCarousel',
                    component: resolve => require(['../pages/setting/CreateSettingCarousel.vue'], resolve)
                }, {
                    name: 'users',
                    path: '/user',
                    component: resolve => require(['../pages/rbac/User.vue'], resolve)
                }, {
                    path: '/role',
                    name: 'roles',
                    component: resolve => require(['../pages/rbac/Role.vue'], resolve)
                }, {
                    name: 'rolePermission',
                    path: '/permission/:role_id',
                    component: resolve => require(['../pages/rbac/Permission.vue'], resolve)
                }, {
                    path: '/reset/password',
                    component: resolve => require(['../pages/auth/ResetPassword.vue'], resolve)
                }, {
                    path: '/test',
                    component: resolve => require(['../pages/Test.vue'], resolve)
                }, {
                    path: '/package',
                    name: 'package',
                    component: resolve => require(['../pages/package/Index.vue'], resolve)
                }, {
                    path: '/package/:id',
                    name: 'showPackage',
                    component: resolve => require(['../pages/package/Show.vue'], resolve)
                },
            ]
        },
        {
            path: '/login',
            component: resolve => require(['../pages/auth/Login.vue'], resolve)
        },
        {
            path: '/register',
            component: resolve => require(['../pages/auth/Register.vue'], resolve)
        },
        {
            path: '/404',
            component: resolve => require(['../pages/errors/404.vue'], resolve)
        },
        {
            path: '/401',
            component: resolve => require(['../pages/errors/401.vue'], resolve)
        },
        {
            path: '*',
            redirect: '/404'
        }
    ]
})

/**
 * Auth Route
 */
function requireAuth(to, from, next) {

    /*
    let encryptAuthUser = window.localStorage.getItem('authUser')
    let encryptToken = window.localStorage.getItem('token')
    let decryptedAuthUser = decryptData(encryptAuthUser);
    let decryptedToken = decryptData(encryptToken);
    */

    let vuexData = JSON.parse(window.localStorage.getItem("vuex"))

    if (vuexData !== null) {
        if (vuexData.auth_user !== null && vuexData.token.access_token) {
            next()
        } else {
            next('/login')
        }
    } else {
        next('/login')
    }
}
