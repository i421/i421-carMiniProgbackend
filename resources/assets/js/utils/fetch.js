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

/**
 * Create Axios
 */
export const http = axios.create({
    baseURL: systemConfig.baseURL,
    timeout: 5000
})


//在实例创建后改变默认值
//http.defaults.headers.common ['Authorization'] = AUTH_TOKEN;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
http.defaults.headers.common = {
    'X-CSRF-ToKen': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest',
};

http.interceptors.request.use(config => {

	NProgress.start()

    //在请求前添加认证头
    /*
    if (store.state.access_token != null) {
        config.headers.authorization = "Bearer " + store.state.access_token;
    } else {
        let access_token = decryptData(window.localStorage.getItem("authUser")).access_token

        if (access_token != 'undefined') {
            config.headers.authorization = "Bearer " + access_token;
        }
    }
    */
    // Do something before request is sent
    return config
}, error => {
    // Do something with request error
	NProgress.done()
    Promise.reject(error)
})

http.interceptors.response.use(function (response) {
	NProgress.done()
	return response;
}, function (error) {
	NProgress.done()
	return Promise.reject(error);
});

http.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    const {response} = error

    if ([401].indexOf(response.status) >= 0) {
        if (response.status == 401 && response.data.message != 'Unauthorized') {
            return Promise.reject(response);
        }
        window.location = '/';
    }

    //根据返回码分别进行处理
    if ([500].indexOf(response.status) >= 0) {
        this.$notify({
            title: 'Notice',
            message: '操作失败',
            type: 'error'
        });
    }

    //格式不符合
    if ([422].indexOf(response.status) >= 0) {
        this.$notify({
            title: 'Notice',
            message: '操作失败',
            type: 'error'
        });
    }

    return Promise.reject(error);
});

export default function install(Vue) {
    Object.defineProperty(Vue.prototype, '$http', {
        get () {
            return http
        },
    })
}
