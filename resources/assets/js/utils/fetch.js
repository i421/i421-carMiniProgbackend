/*
|--------------------------------------------------------------------------
| Http Request
|--------------------------------------------------------------------------
|
| We'll load the axios HTTP library which allows us to easily issue requests
| to our Laravel back-end. This library automatically handles sending the
| CSRF token as a header based on the value of the "XSRF" token cookie.
|
*/

import axios from 'axios'
import store from '../store'
import systemConfig from './../env.js'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
import { Notification } from 'element-ui'
import { decryptData } from './../utils/encrypt'

export const http = axios.create({
    baseURL: systemConfig.baseURL,
    timeout: 5000
})

http.defaults.headers.common = {
    'X-CSRF-ToKen': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest',
};

// Do something before request is sent
http.interceptors.request.use(config => {

	NProgress.start()
    //在请求前添加认证头
    if (store.state.access_token !== null) {
        config.headers.authorization = "Bearer " + store.state.access_token;
    }
    return config

}, error => {
    // Do something with request error
	NProgress.done()
    Promise.reject(error)
})

// Do something before response is sent
http.interceptors.response.use(function (response) {

    //用户名密码错误
    if (response.data.error == "invalid_credentials") {
        Notification({
            title: '提示',
            message: '用户名或者密码错误',
            type: 'error'
        });
	    NProgress.done()
        return Promise.reject(response);
    }

    //passport认证用户ID/密码
    if (response.data.error == "invalid_client") {
        Notification({
            title: '提示',
            message: 'Client信息错误',
            type: 'error'
        });
	    NProgress.done()
        return Promise.reject(response);
    }

    //204空
    if (response.data.code == "204") {
        Notification({
            title: '提示',
            message: response.data.msg,
            type: 'warning'
        });
	    NProgress.done()
        return Promise.reject(response);
    }

    //10004已经存在
    if (response.data.code == "10004") {
        Notification({
            title: '提示',
            message: response.data.msg,
            type: 'warning'
        });
	    NProgress.done()
        return Promise.reject(response);
    }

    //10008密码不一致
    if (response.data.code == "10008") {
        Notification({
            title: '提示',
            message: response.data.msg,
            type: 'warning'
        });
	    NProgress.done()
        return Promise.reject(response);
    }

    //正常返回
	NProgress.done()
    return response;

}, function (error) {

    const {response} = error

    if ([401].indexOf(response.status) >= 0) {

        if (response.data.error == "invalid_credentials") {
            Notification.error({
                title: '错误',
                message: '用户名或者密码错误,请重试'
            });
	        NProgress.done()
            return Promise.reject(response);
        }

        if (response.data.message == "invalid_client") {
            Notification.error({
                title: '错误',
                message: '认证信息出错'
            });
	        NProgress.done()
            return Promise.reject(response);
        }

        if (response.data.message == "Unauthenticated.") {

            window.localStorage.removeItem('vuex')

            Notification.error({
                title: '错误',
                message: '令牌错误,请重新登录'
            });

            window.location.href = "/#/login";

            NProgress.done()
            return Promise.reject(response);
        }
    }

    //格式不符合
    if ([413].indexOf(response.status) >= 0) {
        Notification({
            title: 'Notice',
            message: '文件大小超过上限',
            type: 'error'
        });
        NProgress.done()
        return Promise.reject(error);
    }

    //格式不符合
    if ([422].indexOf(response.status) >= 0) {
        Notification({
            title: 'Notice',
            message: '操作失败',
            type: 'error'
        });
        NProgress.done()
        return Promise.reject(error);
    }

    //根据返回码分别进行处理
    if ([500].indexOf(response.status) >= 0) {
        Notification({
            title: 'Notice',
            message: '操作失败',
            type: 'error'
        });
        NProgress.done()
        return Promise.reject(response);
    }

});

export default function install(Vue) {
    Object.defineProperty(Vue.prototype, '$http', {
        get () {
            return http
        },
    })
}
