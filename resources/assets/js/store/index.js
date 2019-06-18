import Vue from 'vue'
import Vuex from 'vuex'
import state from './state'
import mutations from './mutations'
import actions from './actions'
import getters from './getters'
import Users from './modules/Users/index'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

const store = new Vuex.Store({
    state,
    mutations,
    actions,
    getters,
    modules: {
        Users
    },
    strict: debug
})

export default store
