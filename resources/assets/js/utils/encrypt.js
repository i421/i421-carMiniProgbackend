/*
|--------------------------------------------------------------------------
| Encrypt and Decrypt 
|--------------------------------------------------------------------------
|
| We'll encrypt the data before store in the browser with Aes.
|
*/

import { AES, enc } from 'crypto-js'
import CryptoJS from "crypto-js"
import systemConfig from './../env.js'

//前端加密
export function encryptData(str) {
    let encryptStr = AES.encrypt(JSON.stringify(str), systemConfig.aesEncryptKey);
    return encryptStr;
}

//前端解密
export function decryptData(str) {
    if (str === null) {
        return '';
    }

    let bytes = AES.decrypt(str.toString(), systemConfig.aesEncryptKey)
    let decryptedStr = JSON.parse(bytes.toString(enc.Utf8))

    return decryptedStr;
}

//前端加密至后端
export function aesEncrypt(plainText) {
    var encrypted = CryptoJS.AES.encrypt(
            plainText,
            CryptoJS.enc.Utf8.parse(systemConfig.aesKey),
            {iv:  CryptoJS.enc.Utf8.parse(systemConfig.aesIv)}
    );
    return CryptoJS.enc.Base64.stringify(encrypted.ciphertext);
}
