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
                    path: '/user',
                    component: resolve => require(['../pages/User.vue'], resolve)
                }, {
                    path: '/reset/password',
                    component: resolve => require(['../pages/auth/ResetPassword.vue'], resolve)
                }, {
                    path: '/role',
                    component: resolve => require(['../pages/Role.vue'], resolve)
                }, {
                    path: '/permission',
                    component: resolve => require(['../pages/Permission.vue'], resolve)
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
