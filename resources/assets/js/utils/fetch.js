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
import { Loading, Notification } from 'element-ui'
import { decryptData } from './../utils/encrypt'

export const http = axios.create({
    baseURL: systemConfig.baseURL,
    timeout: 5000
})

let loading

http.defaults.headers.common = {
    'X-CSRF-ToKen': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest',
};

// Do something before request is sent
http.interceptors.request.use(config => {

	NProgress.start()
    loading = Loading.service({ fullscreen: true });
    //在请求前添加认证头
    if (store.state.token.access_token !== null) {
        config.headers.authorization = "Bearer " + store.state.token.access_token;
    }
    return config

}, error => {
    // Do something with request error
    loading.close();
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
        loading.close();
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
        loading.close();
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
        loading.close();
        return Promise.reject(response);
    }

    //10004已经存在
    if (response.data.code == "10004") {
        Notification({
            title: '提示',
            message: response.data.msg,
            type: 'warning'
        });
        loading.close();
	    NProgress.done()
        return Promise.reject(response);
    }

    //20004文件太大
    if (response.data.code == "20004") {
        Notification({
            title: '提示',
            message: response.data.msg,
            type: 'warning'
        });
	    NProgress.done()
        loading.close();
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
        loading.close();
        return Promise.reject(response);
    }

    loading.close();

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
            loading.close();
            return Promise.reject(response);
        }

        if (response.data.message == "invalid_client") {
            Notification.error({
                title: '错误',
                message: '认证信息出错'
            });
	        NProgress.done()
            loading.close();
            return Promise.reject(response);
        }

        if (response.data.message == "Unauthenticated.") {

            const originalRequest = response.config
            originalRequest._retry = true

            return axios.post('oauth/token', {
                grant_type: 'refresh_token',
                refresh_token: store.state.token.refresh_token,
                client_id: systemConfig.clientId,
                client_secret: systemConfig.clientSecret,
                scope: ''
            }).then(function (response) {
                store.dispatch('setToken', response.data)
                originalRequest.headers.authorization = "Bearer " + response.data.access_token;
                return axios(originalRequest)
            })
            .catch(function (error) {
                console.log(error);
            });

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
        loading.close();
        return Promise.reject(error);
    }

    //格式不符合
    if ([422].indexOf(response.status) >= 0) {
        for (let i in response.data.errors) {
            for (let j = 0; j < response.data.errors[i].length; j++) {
                let info = response.data.errors[i][j]
                    Notification({
                        title: 'Notice',
                        message: info,
                        type: 'error'
                    });
            }
        }
        loading.close();
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
        loading.close();
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
