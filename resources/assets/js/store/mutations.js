/*
|--------------------------------------------------------------------------
| mutation (同步操作)
|--------------------------------------------------------------------------
|
*/
import * as types from './mutation-types'
import { app } from './../app'

// this => store

export default {

    //设置语言
    [types.SET_LANGUAGE](state, payload) {
        app.$i18n.locale = payload
        window.sessionStorage.setItem('locale', payload)
    },

    //设置AccessToken
    [types.SET_ACCESS_TOKEN](state, payload) {
        state.access_token = payload
    },

    //设置头像
    [types.SET_AVATAR](state, payload) {
        state.auth_user.avatar = payload
    },

    //设置系统版本
    [types.SET_SYS_VERSION](state, payload) {
        state.sys_version = payload
    },

    //设置认证用户
    [types.SET_AUTH_USER](state, payload) {
        state.auth_user = payload
    },

    //清除认证用户
    [types.CLEAR_AUTH_USER] (state) {
        state.auth_user = null
    },

    //登录并重置vuex信息
    [types.DO_LOGOUT] (state) {
        state.auth_user = null
        state.access_token = null
    }
}
