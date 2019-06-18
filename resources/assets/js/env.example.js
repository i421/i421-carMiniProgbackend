
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
    'clientId': '',
    'clientSecret': '',
    'version': '1.0.0',
    'encryptKey': 'justGuess',
    'autoRefreshMinTime': '20000',
    'autoRefreshMidTime': '15000',
    'autoRefreshMaxTime': '10000',
}

export default systemConfig
