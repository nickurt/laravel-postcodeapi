<?php 

namespace nickurt\PostcodeApi;

use \nickurt\PostcodeApi\ProviderFactory;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('PostcodeApi', function($app)
        {
            return new ProviderFactory();
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/postcodeapi.php' => config_path('postcodeapi.php'),
        ]);
        
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['PostcodeApi'];
    }
}
