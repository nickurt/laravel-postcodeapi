<?php

namespace nickurt\PostcodeApi;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/postcodeapi.php' => config_path('postcodeapi.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('PostcodeApi', function ($app) {
            return new ProviderFactory();
        });
    }
}
