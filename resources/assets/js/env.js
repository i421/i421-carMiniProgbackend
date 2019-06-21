
/*
|--------------------------------------------------------------------------
| System config
|--------------------------------------------------------------------------
| system version 
| system passportClient
| system baseUrl
| system encryptKey
| system autoRefreshTime
|
| the client use password mode to auth. So the password_client column should be true (1).
*/

const systemConfig = {
    'baseUrl': '/',
    'clientId': '1',
    'clientSecret': 'P2h0e1i8c0l1o0u1d888aaaqsBVXTbV2wsBEm5cq',
    'version': '1.0.0',
    'encryptKey': 'justGuess',
    'autoRefreshMinTime': '20000',
    'autoRefreshMidTime': '15000',
    'autoRefreshMaxTime': '10000',
    'aesEncryptKey': 'justGuess',
    'aesIv': '28scvb10s3tavztk',
    'aesKey': 'darlingml5tavshp',
}

export default systemConfig
