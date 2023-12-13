<?php

namespace App\Providers;

use App\User;
use App\Services\UserServiceProvider;
use App\Services\UserService;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class UseUserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('user-service', function ($app, array $config) {

            return new UserServiceProvider(new User(new UserService()));
        });

    }
}
