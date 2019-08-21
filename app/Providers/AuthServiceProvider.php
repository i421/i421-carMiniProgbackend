<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Auth;
use App\Extensions\DarlingUserProvider;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->_configPassport();
        $this->_registerDarlingUserProvider();
    }

    /**
     * Config Passport
     *
     * return void
     */
    private function _configPassport()
    {
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addHour());
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
    }

    /**
     * Register UserProvider
     *
     * @return void
     */
    private function _registerDarlingUserProvider()
    {
        Auth::provider('darling', function ($app, array $config) {
            return new DarlingUserProvider(new BcryptHasher(), config('auth.providers.darling.model'));
        });
    }
}
