/*
|--------------------------------------------------------------------------
| actions (异步操作)
|--------------------------------------------------------------------------
|
*/
import * as types from './mutation-types'

export default {

    setLanguage(context, payload) {
        context.commit(types.SET_LANGUAGE, payload)
    },

    setAccessToken(context, payload) {
        context.commit(types.SET_ACCESS_TOKEN, payload)
    }
}
