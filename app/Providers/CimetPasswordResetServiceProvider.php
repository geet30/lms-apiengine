<?php

namespace App\Providers;

use App\Http\Services\CimetPasswordBrokerManager;
use Illuminate\Support\ServiceProvider;

class CimetPasswordResetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    protected $defer = true;

    public function register()
    {
        $this->registerPasswordBrokerManager();
    }

    protected function registerPasswordBrokerManager()
    {
        $this->app->singleton('auth.password', function ($app) {
            return new CimetPasswordBrokerManager($app);
        });
    }

    public function provides()
    {
        return ['auth.password'];
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
