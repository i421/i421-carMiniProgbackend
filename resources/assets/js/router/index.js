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
                    component: resolve => require(['../pages/Dashboard.vue'], resolve)
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
                    path: '/brand',
                    component: resolve => require(['../pages/brand/Index.vue'], resolve)
                }, {
                    path: '/brand/show',
                    component: resolve => require(['../pages/brand/Show.vue'], resolve)
                }, {
                    path: '/shop',
                    component: resolve => require(['../pages/Shop.vue'], resolve)
                }, {
                    path: '/car',
                    component: resolve => require(['../pages/Car.vue'], resolve)
                }, {
                    path: '/group',
                    component: resolve => require(['../pages/Group.vue'], resolve)
                }, {
                    path: '/order',
                    component: resolve => require(['../pages/Order.vue'], resolve)
                }, {
                    path: '/message',
                    component: resolve => require(['../pages/Message.vue'], resolve)
                }, {
                    path: '/setting',
                    component: resolve => require(['../pages/Setting.vue'], resolve)
                }, {
                    name: 'users',
                    path: '/user',
                    component: resolve => require(['../pages/rbac/User.vue'], resolve)
                }, {
                    path: '/role',
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
        if (vuexData.auth_user !== null && vuexData.access_token) {
            next()
        } else {
            next('/login')
        }
    } else {
        next('/login')
    }
}
