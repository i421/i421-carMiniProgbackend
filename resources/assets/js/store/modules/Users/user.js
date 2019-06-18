import * as types from '../mutation-types'
import { AES, enc } from 'crypto-js'
import { systemEncryptKey } from '../../env.js'

const user = {

    //initial state
    state = {
        authUser = null
    }

    //getters
    getters = {
        decryptedAuthUser () {
            const cryptedAuthUser = state.authUser
            let bytes  = AES.decrypt(cryptedAuthUser.toString(), systemEncryptKey);
            let decryptedData = JSON.parse(bytes.toString(enc.Utf8));
            return decryptedData
        }
    }

    //actions
    actions = {

        setUserObject: ({commit}, userObj) => {
            let ciphertext = AES.encrypt(JSON.stringify(userObj), systemEncryptKey);
            commit(types.SET_AUTH_USER, ciphertext)
        },

        clearAuthUser: ({commit}) => {
            commit(types.CLEAR_AUTH_USER)
        }
    }

    //mutation
    mutation = {
        [types.SET_AUTH_USER] (state, userObj) {
            state.authUser = userObj;
        },

        [types.CLEAR_AUTH_USER] (state) {
            state.authUser = null;
        }
    }
}

export default user;
