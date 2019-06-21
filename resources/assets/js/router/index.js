import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
    routes: [
        //{
        //    path: '/',
        //    redirect: '/register'
        //},
        {
            path: '/',
            component: resolve => require(['./../components/layout/Home.vue'], resolve),
            children: [
                {
                    path: '/test',
                    component: resolve => require(['../pages/test.vue'], resolve)
                },
            ]
        },
        {
            path: '/login',
            component: resolve => require(['../pages/auth/Login.vue'], resolve)
        },
        {
            path: '/register',
            component: resolve => require(['../pages/auth/register.vue'], resolve)
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
