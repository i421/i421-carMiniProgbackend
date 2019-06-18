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
                    path: '/register',
                    component: resolve => require(['../pages/register.vue'], resolve)
                },
            ]
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
