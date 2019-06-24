/*
|--------------------------------------------------------------------------
| actions (异步操作)
|--------------------------------------------------------------------------
|
*/
import * as types from './mutation-types'

export default {

    //设置语言
    setLanguage(context, payload) {
        context.commit(types.SET_LANGUAGE, payload)
    },

    //设置AccessToken
    setAccessToken(context, payload) {
        context.commit(types.SET_ACCESS_TOKEN, payload)
    },

    //设置系统版本
    setSysVersion(context, payload) {
        context.commit(types.SET_SYS_VERSION, payload)
    },

    //设置认证用户
    setAuthUser(context, payload) {
        context.commit(types.SET_AUTH_USER, payload)
    },

    //清除用户信息
    clearAuthUser(context, payload) {
        context.commit(types.CLEAR_AUTH_USER, payload)
    },

    //登出并重置vuex状态
    doLogout(context, payload) {
        context.commit(types.DO_LOGOUT, payload)
    }
}
