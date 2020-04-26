<?php

namespace nickurt\PostcodeApi\tests;

use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        config()->set('postcodeapi', [
            'providers' => [
                'NationaalGeoRegister' => [
                    'driver' => 'NationaalGeoRegister',
                    //
                ],
            ]
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'PostcodeApi' => \nickurt\PostcodeApi\Facades\PostcodeApi::class
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \nickurt\PostcodeApi\ServiceProvider::class
        ];
    }
}
