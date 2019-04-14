<?php

namespace App\Providers;

use Admin\Models\Stuff;
use App\Guards\CookieGuard;
use App\Guards\CustomTokenGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // add admin guard provider
        Auth::provider('stuffs', function ($app, array $config) {
            return new EloquentStuffProvider($app->make(Stuff::class));
        });

        // add admin guard driver
        Auth::extend('cookie', function ($app, $name, array $config) {
            return new CookieGuard(Auth::createUserProvider($config['provider']), $app->make('request'));
        });

        /** Add api guard driver custom_token **/
        Auth::extend('custom_token', function ($app, $name, array $config) {
            return new CustomTokenGuard(Auth::createUserProvider($config['provider']), $app->make('request'));
        });
    }
}
