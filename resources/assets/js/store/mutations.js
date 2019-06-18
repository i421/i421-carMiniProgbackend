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

    [types.SET_LANGUAGE](state, payload) {
        app.$i18n.locale = payload
        window.sessionStorage.setItem('locale', payload)
    },

    [types.SET_ACCESS_TOKEN](state, payload) {
        state.access_token = payload
    }

}
